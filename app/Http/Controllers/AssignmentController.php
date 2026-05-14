<?php

namespace App\Http\Controllers;

use App\Models\Complaint;
use App\Models\User;
use App\Enums\UserRole;
use App\Enums\ComplaintStatus;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Illuminate\Support\Facades\Auth; // Tambahkan ini

class AssignmentController extends Controller
{
    /**
     * Menampilkan daftar laporan yang sudah VERIFIED untuk ditugaskan.
     */
    public function index(): View
    {
        // 1. Ambil laporan yang sudah diverifikasi FO tapi belum ada petugasnya
        $complaints = Complaint::with(['user', 'category'])
            ->where('status', ComplaintStatus::VERIFIED)
            ->latest()
            ->get();

        // 2. Ambil daftar user dengan role Pelaksana Lapangan
        $officers = User::where('role', UserRole::PELAKSANA)->get();

        return view('kasi.assignment.index', compact('complaints', 'officers'));
    }

    /**
     * Menyimpan penugasan petugas ke pengaduan tertentu.
     */
    public function store(Request $request, Complaint $complaint): RedirectResponse
    {
        // Tambahkan validasi agar role yang dipilih benar-benar PELAKSANA
        $request->validate([
            'assigned_to' => [
                'required',
                'exists:users,id',
                // Opsional: Validasi tambahan memastikan ID tersebut memang role pelaksana
            ],
        ]);

        // Update status menjadi ASSIGNED dan tentukan petugasnya
        $complaint->update([
            'assigned_to' => $request->assigned_to,
            'status' => ComplaintStatus::ASSIGNED,
        ]);

        // (Opsional) Catat ke history bahwa Kasi telah menugaskan petugas
        // $complaint->histories()->create([
        //     'user_id' => Auth::id(),
        //     'status' => ComplaintStatus::ASSIGNED,
        //     'notes' => 'Petugas telah ditunjuk oleh Kasi.',
        // ]);

        return redirect()->route('kasi.assignment.index')
            ->with('success', 'Petugas lapangan berhasil ditugaskan untuk laporan ini.');
    }
}