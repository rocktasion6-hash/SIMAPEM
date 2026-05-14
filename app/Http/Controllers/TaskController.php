<?php

namespace App\Http\Controllers;

use App\Models\Complaint;
use App\Models\ComplaintHistory;
use App\Models\User; // Tambahkan import Model User
use App\Enums\ComplaintStatus;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth; // Tambahkan import Fasad Auth

class TaskController extends Controller
{
    /**
     * Menampilkan daftar tugas yang ditugaskan ke petugas lapangan yang sedang login.
     */
    public function index(): View
    {
        /** @var User $user */
        $user = Auth::user();

        // Mengambil tugas dengan status ASSIGNED atau IN_PROGRESS
        $tasks = Complaint::with(['user', 'category'])
            ->where('assigned_to', $user->id) // Menggunakan $user->id yang sudah di-hint
            ->whereIn('status', [
                ComplaintStatus::ASSIGNED, 
                ComplaintStatus::IN_PROGRESS
            ])
            ->latest()
            ->paginate(10);

        return view('pelaksana.tasks.index', compact('tasks'));
    }

    /**
     * Menampilkan detail tugas dan form untuk update progres.
     */
    public function show(Complaint $complaint): View
    {
        /** @var User $user */
        $user = Auth::user();

        // Pastikan petugas hanya bisa melihat tugas miliknya sendiri
        if ($complaint->assigned_to !== $user->id) {
            abort(403, 'Tugas ini bukan milik Anda.');
        }

        return view('pelaksana.tasks.show', compact('complaint'));
    }

    /**
     * Memperbarui status tugas dan mengunggah bukti pengerjaan.
     */
    public function update(Request $request, Complaint $complaint): RedirectResponse
    {
        /** @var User $user */
        $user = Auth::user();

        // Validasi input
        $request->validate([
            'status' => 'required|in:in_progress,resolved',
            'notes' => 'required|string|min:10',
            'action_photo' => 'required_if:status,resolved|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $photoPath = null;
        
        // Jika status selesai (resolved), petugas wajib upload foto bukti pengerjaan
        if ($request->hasFile('action_photo')) {
            $photoPath = $request->file('action_photo')->store('task_evidences', 'public');
        }

        // 1. Update status di tabel complaints
        $newStatus = $request->status === 'resolved' 
            ? ComplaintStatus::RESOLVED 
            : ComplaintStatus::IN_PROGRESS;

        $complaint->update([
            'status' => $newStatus,
        ]);

        // 2. Catat riwayat pengerjaan di tabel complaint_histories
        ComplaintHistory::create([
            'complaint_id' => $complaint->id,
            'user_id' => $user->id, // Garis merah hilang di sini
            'status' => $newStatus,
            'notes' => $request->notes,
            'action_photo_path' => $photoPath,
        ]);

        return redirect()->route('pelaksana.tasks.index')
            ->with('success', 'Laporan progres berhasil disimpan.');
    }
}