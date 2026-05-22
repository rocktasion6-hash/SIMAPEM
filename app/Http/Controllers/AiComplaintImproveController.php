<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class AiComplaintImproveController extends Controller
{
    public function improve(Request $request)
    {
        $request->validate([
            'description' => 'required|string|min:5',
        ]);

        $prompt = "
Kamu adalah AI Assistant SIMAPEM.

Tugas kamu hanya memperbaiki deskripsi laporan warga agar lebih rapi.

Aturan wajib:
- Jangan menambahkan informasi baru yang tidak ada di teks asli.
- Jangan menambahkan nama lokasi, tanggal, status, petugas, atau kondisi yang tidak disebutkan.
- Jangan membuat cerita tambahan.
- Jangan mengubah makna laporan.
- Gunakan bahasa Indonesia formal, singkat, jelas, dan sopan.
- Jawab hanya hasil deskripsi yang sudah diperbaiki.
- Jangan memakai awalan seperti 'Deskripsi laporan warga:'.

Teks asli:
{$request->description}

Hasil perbaikan:
";

        try {
            $url = rtrim(config('services.ollama.url'), '/');
            $model = config('services.ollama.model');

            $response = Http::timeout(90)->post($url . '/api/generate', [
                'model' => $model,
                'prompt' => $prompt,
                'stream' => false,
                'options' => [
                    'temperature' => 0.2,
                    'top_p' => 0.7,
                ],
            ]);

            if (!$response->successful()) {
                return response()->json([
                    'message' => 'AI sedang tidak dapat digunakan. Pastikan Ollama berjalan.',
                ], 500);
            }

            $improvedDescription = trim($response->json('response'));

            return response()->json([
                'description' => $improvedDescription,
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Tidak dapat terhubung ke Ollama.',
            ], 500);
        }
    }
}