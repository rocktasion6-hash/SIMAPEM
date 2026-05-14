<?php

namespace App\Http\Controllers;

use App\Models\Complaint;
use App\Models\Category;
use App\Enums\ComplaintStatus;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class VerificationController extends Controller
{
    /**
     * Menampilkan daftar pengaduan yang berstatus PENDING.
     */
    public function index(): View
    {
        // Mengambil laporan yang perlu diverifikasi
        $complaints = Complaint::with('user')
            ->where('status', ComplaintStatus::PENDING)
            ->latest()
            ->paginate(10);

        // Mengambil semua kategori untuk pilihan dropdown saat verifikasi
        $categories = Category::all();

        return view('fo.verifikasi.index', compact('complaints', 'categories'));
    }

    /**
     * Memperbarui status pengaduan (Diterima/Diverifikasi atau Ditolak).
     */
    public function update(Request $request, Complaint $complaint): RedirectResponse
    {
        // Validasi input
        $request->validate([
            'status' => 'required|in:verified,rejected', 
            'category_id' => 'required_if:status,verified|exists:categories,id',
            'notes' => 'nullable|string|max:500', // Opsional: alasan penolakan atau catatan FO
        ]);

        // Tentukan status berdasarkan input
        $newStatus = $request->status === 'verified' 
            ? ComplaintStatus::VERIFIED 
            : ComplaintStatus::REJECTED;

        // Update data pengaduan
        $complaint->update([
            'status' => $newStatus,
            'category_id' => $request->status === 'verified' ? $request->category_id : $complaint->category_id,
        ]);

        // Jika Anda ingin mencatat riwayat perubahan status (Opsional)
        // $complaint->histories()->create([
        //     'user_id' => auth()->id(),
        //     'status' => $newStatus,
        //     'notes' => $request->notes,
        // ]);

        return redirect()->route('fo.verifikasi.index')
            ->with('success', 'Laporan berhasil diperbarui.');
    }
}