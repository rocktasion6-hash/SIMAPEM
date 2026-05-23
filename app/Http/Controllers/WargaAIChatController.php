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
        $message = $request->message;
        $lowerMessage = strtolower($message);

        $isTrackingQuestion =
            str_contains($lowerMessage, 'laporan saya') ||
            str_contains($lowerMessage, 'status') ||
            str_contains($lowerMessage, 'tracking') ||
            str_contains($lowerMessage, 'kode') ||
            str_contains($lowerMessage, 'sampai mana') ||
            str_contains($lowerMessage, 'sudah sampai') ||
            preg_match('/SIMAPEM-[A-Z0-9]+/i', $message);

        if ($isTrackingQuestion) {
            return $this->answerTrackingQuestion($request, $user);
        }

        return $this->answerGeneralQuestion($request);
    }

    private function answerTrackingQuestion(Request $request, $user)
    {
        preg_match('/SIMAPEM-[A-Z0-9]+/i', $request->message, $matches);

        $complaint = null;

        if (!empty($matches)) {
            $complaint = Complaint::with(['category', 'assignedTo'])
                ->where('user_id', $user->id)
                ->where('tracking_code', strtoupper($matches[0]))
                ->first();
        }

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
Jangan mengubah status laporan.
Jawab dengan bahasa Indonesia yang sopan, singkat, dan mudah dipahami.

Data laporan:
{$dataLaporan}

Pertanyaan warga:
{$request->message}
";

        return $this->askOllama($prompt, 'Maaf, AI sedang tidak dapat digunakan. Namun status laporan Anda adalah: ' . $statusText . '.');
    }

    private function answerGeneralQuestion(Request $request)
    {
        $knowledge = "
Informasi tentang SIMAPEM:

SIMAPEM adalah Sistem Pengaduan Masyarakat yang digunakan untuk membantu warga menyampaikan laporan atau pengaduan secara online.

Fitur utama untuk warga:
- Membuat laporan pengaduan.
- Melihat daftar laporan yang sudah dibuat.
- Melihat detail laporan.
- Melacak status laporan.
- Mengedit atau menghapus laporan selama status masih pending.

Alur pengaduan:
1. Warga membuat laporan.
2. Front Office memverifikasi laporan.
3. Kasi menugaskan laporan kepada petugas pelaksana.
4. Petugas pelaksana menangani laporan.
5. Laporan diselesaikan setelah proses penanganan selesai.

Arti status laporan:
- pending: laporan menunggu verifikasi.
- verified: laporan sudah diverifikasi.
- assigned: laporan sudah ditugaskan ke petugas.
- in_progress: laporan sedang dikerjakan.
- resolved: laporan sudah selesai.
- rejected: laporan ditolak atau tidak dapat diproses.

Contoh laporan yang bisa dibuat:
- Jalan rusak.
- Sampah menumpuk.
- Lampu jalan mati.
- Drainase bermasalah.
- Fasilitas umum rusak.

Batasan:
AI tidak boleh mengarang data laporan warga.
Jika warga bertanya status laporan, arahkan warga untuk menyebutkan kode tracking atau bertanya 'laporan saya sudah sampai mana?'.
";

        $prompt = "
Kamu adalah AI Assistant SIMAPEM.

Jawab pertanyaan warga berdasarkan informasi sistem berikut.
Gunakan bahasa Indonesia yang sopan, jelas, singkat, dan mudah dipahami.
Jangan menjawab di luar konteks SIMAPEM.
Jika pertanyaan tidak berhubungan dengan SIMAPEM, arahkan kembali ke layanan pengaduan masyarakat.

Informasi sistem:
{$knowledge}

Pertanyaan warga:
{$request->message}
";

        return $this->askOllama($prompt, 'Maaf, AI sedang tidak dapat digunakan. Silakan tanyakan kembali seputar SIMAPEM atau status laporan Anda.');
    }

    private function askOllama(string $prompt, string $fallbackMessage)
    {
        try {
            $url = rtrim((string) config('services.ollama.url', 'http://localhost:11434'), '/');
            $model = (string) config('services.ollama.model', 'gemma:2b');

            $response = Http::timeout(90)->post($url . '/api/chat', [
                'model' => $model,
                'messages' => [
                    [
                        'role' => 'user',
                        'content' => $prompt,
                    ],
                ],
                'stream' => false,
                'options' => [
                    'temperature' => 0.3,
                    'top_p' => 0.8,
                ],
            ]);

            if (!$response->successful()) {
                return response()->json([
                    'reply' => $fallbackMessage,
                ]);
            }

            $reply = $response->json('message.content');

            return response()->json([
                'reply' => $reply ?: $fallbackMessage,
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'reply' => $fallbackMessage,
            ]);
        }
    }
}