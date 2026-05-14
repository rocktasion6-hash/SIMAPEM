<?php

namespace App\Http\Controllers;

use App\Models\Complaint;
use App\Models\User;
use App\Enums\ComplaintStatus;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;

class ComplaintController extends Controller
{
    /**
     * Menampilkan daftar laporan milik warga yang sedang login.
     */
    public function index()
    {
        /** @var User $user */
        $user = Auth::user(); 

        // Mengambil pengaduan milik user dengan pagination
        $complaints = $user->complaints()->latest()->paginate(10);
        
        return view('warga.complaints.index', compact('complaints'));
    }

    /**
     * Menampilkan form untuk membuat laporan baru.
     */
    public function create()
    {
        return view('warga.complaints.create');
    }

    /**
     * Menyimpan laporan baru ke database.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'photo' => 'required|image|mimes:jpg,jpeg,png|max:2048',
            'latitude' => 'nullable|numeric',
            'longitude' => 'nullable|numeric',
        ]);

        $photoPath = null;
        if ($request->hasFile('photo')) {
            $photoPath = $request->file('photo')->store('complaints', 'public');
        }

        Complaint::create([
            'tracking_code' => 'SIMAPEM-' . strtoupper(Str::random(6)),
            'user_id' => Auth::id(),
            'title' => $request->title,
            'description' => $request->description,
            'photo_path' => $photoPath,
            'latitude' => $request->latitude,
            'longitude' => $request->longitude,
            'status' => ComplaintStatus::PENDING,
        ]);

        return redirect()->route('warga.complaints.index')
            ->with('success', 'Laporan berhasil dikirim!');
    }

    /**
     * Menampilkan detail laporan tertentu.
     */
    public function show(Complaint $complaint)
    {
        // Keamanan: Pastikan warga hanya bisa melihat laporannya sendiri
        if ($complaint->user_id !== Auth::id()) {
            abort(403, 'Anda tidak memiliki akses ke laporan ini.');
        }

        return view('warga.complaints.show', compact('complaint'));
    }

    /**
     * Menampilkan form edit laporan.
     */
    public function edit(Complaint $complaint)
    {
        // Keamanan: Hanya bisa edit jika milik sendiri DAN status masih pending
        if ($complaint->user_id !== Auth::id() || $complaint->status->value !== 'pending') {
            abort(403, 'Laporan yang sudah diproses tidak dapat diubah.');
        }

        return view('warga.complaints.edit', compact('complaint'));
    }

    /**
     * Memperbarui data laporan di database.
     */
    public function update(Request $request, Complaint $complaint)
    {
        // Keamanan tambahan sebelum update
        if ($complaint->user_id !== Auth::id() || $complaint->status->value !== 'pending') {
            abort(403);
        }

        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'photo' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'latitude' => 'nullable|numeric',
            'longitude' => 'nullable|numeric',
        ]);

        $data = [
            'title' => $request->title,
            'description' => $request->description,
            'latitude' => $request->latitude,
            'longitude' => $request->longitude,
        ];

        if ($request->hasFile('photo')) {
            // Hapus foto lama jika ada file baru yang diunggah
            if ($complaint->photo_path) {
                Storage::disk('public')->delete($complaint->photo_path);
            }
            $data['photo_path'] = $request->file('photo')->store('complaints', 'public');
        }

        $complaint->update($data);

        return redirect()->route('warga.complaints.index')
            ->with('success', 'Laporan berhasil diperbarui!');
    }

    /**
     * Menghapus laporan.
     */
    public function destroy(Complaint $complaint)
    {
        // Keamanan: Pastikan milik sendiri dan masih pending
        if ($complaint->user_id !== Auth::id() || $complaint->status->value !== 'pending') {
            abort(403, 'Laporan tidak dapat dihapus karena sedang diproses.');
        }

        // Hapus file fisik foto dari storage sebelum hapus data di database
        if ($complaint->photo_path) {
            Storage::disk('public')->delete($complaint->photo_path);
        }

        $complaint->delete();

        return redirect()->route('warga.complaints.index')
            ->with('success', 'Laporan berhasil dihapus!');
    }
}