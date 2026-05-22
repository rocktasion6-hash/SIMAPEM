<?php

namespace App\Http\Controllers;

use App\Models\Complaint;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Auth;

class WargaAIChatController extends Controller
{
    public function chat(Request $request)
    {
        $request->validate([
            'message' => 'required|string|min:2',
        ]);

        $user = Auth::user();

        // Cari kode tracking di pesan warga, contoh: SIMAPEM-ABC123
        preg_match('/SIMAPEM-[A-Z0-9]+/i', $request->message, $matches);

        $complaint = null;

        if (!empty($matches)) {
            $complaint = Complaint::with(['category', 'assignedTo'])
                ->where('user_id', $user->id)
                ->where('tracking_code', strtoupper($matches[0]))
                ->first();
        }

        // Kalau warga tidak menulis kode tracking,
        // ambil laporan terbaru milik warga
        if (!$complaint) {
            $complaint = Complaint::with(['category', 'assignedTo'])
                ->where('user_id', $user->id)
                ->latest()
                ->first();
        }

        if (!$complaint) {
            return response()->json([
                'reply' => 'Anda belum memiliki laporan. Silakan buat laporan terlebih dahulu melalui menu Buat Laporan.',
            ]);
        }

        $statusText = match ($complaint->status->value) {
            'pending' => 'menunggu verifikasi oleh Front Office',
            'verified' => 'sudah diverifikasi dan menunggu penugasan petugas',
            'assigned' => 'sudah ditugaskan kepada petugas pelaksana',
            'in_progress' => 'sedang dalam proses pengerjaan oleh petugas',
            'resolved' => 'sudah selesai ditangani',
            'rejected' => 'ditolak atau tidak dapat diproses',
            default => 'sedang diproses',
        };

        $categoryName = $complaint->category->name ?? 'belum dikategorikan';
        $assignedName = $complaint->assignedTo->name ?? 'belum ada petugas yang ditugaskan';

        $dataLaporan = "
Kode tracking: {$complaint->tracking_code}
Judul laporan: {$complaint->title}
Kategori: {$categoryName}
Status: {$statusText}
Petugas: {$assignedName}
Tanggal dibuat: {$complaint->created_at->format('d M Y H:i')}
";

        $prompt = "
Kamu adalah AI Assistant SIMAPEM.

Jawab pertanyaan warga berdasarkan data laporan berikut.
Jangan mengarang data baru.

Data laporan:
{$dataLaporan}

Pertanyaan warga:
{$request->message}

Jawab dengan bahasa Indonesia yang sopan, singkat, dan mudah dipahami.
";

        try {
            $url = rtrim(config('services.ollama.url'), '/');
            $model = config('services.ollama.model');

            $response = Http::timeout(90)->post($url . '/api/chat', [
                'model' => $model,
                'messages' => [
                    [
                        'role' => 'user',
                        'content' => $prompt,
                    ],
                ],
                'stream' => false,
            ]);

            if (!$response->successful()) {
                return response()->json([
                    'reply' => 'Maaf, AI sedang tidak dapat digunakan. Namun status laporan Anda adalah: ' . $statusText . '.',
                ]);
            }

            return response()->json([
                'reply' => $response->json('message.content') ?? 'Status laporan Anda adalah: ' . $statusText . '.',
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'reply' => 'Maaf, AI tidak dapat terhubung ke Ollama. Namun status laporan Anda adalah: ' . $statusText . '.',
            ]);
        }
    }
}