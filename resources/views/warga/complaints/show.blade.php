<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-900 leading-tight">
                {{ __('Detail Laporan') }}
            </h2>

            <a href="{{ route('warga.complaints.index') }}"
                class="text-sm font-bold text-blue-600 hover:text-blue-800 transition">
                &larr; Kembali ke Daftar
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">

            <div class="bg-black/35 backdrop-blur-xl overflow-hidden shadow-2xl sm:rounded-3xl border border-white/20 text-white">

                <!-- Header Status -->
                <div class="p-8 border-b border-white/10 bg-white/10 flex flex-wrap justify-between items-center gap-4">
                    <div>
                        <p class="text-[10px] font-black uppercase tracking-[0.2em] text-white/50">
                            Kode Tracking
                        </p>

                        <h3 class="text-lg font-mono font-bold text-white">
                            {{ $complaint->tracking_code }}
                        </h3>
                    </div>

                    <div class="text-right">
                        <p class="text-[10px] font-black uppercase tracking-[0.2em] text-white/50 mb-1">
                            Status Saat Ini
                        </p>

                        <span class="px-4 py-1.5 rounded-full text-xs font-black uppercase tracking-widest
                            @if($complaint->status->value == 'pending')
                                bg-amber-400/20 text-amber-200 border border-amber-300/30
                            @elseif($complaint->status->value == 'resolved')
                                bg-emerald-400/20 text-emerald-200 border border-emerald-300/30
                            @elseif($complaint->status->value == 'rejected')
                                bg-rose-400/20 text-rose-200 border border-rose-300/30
                            @else
                                bg-blue-400/20 text-blue-200 border border-blue-300/30
                            @endif">

                            @if($complaint->status->value == 'pending')
                                Menunggu
                            @elseif($complaint->status->value == 'resolved')
                                Selesai
                            @elseif($complaint->status->value == 'rejected')
                                Ditolak
                            @else
                                {{ $complaint->status->value }}
                            @endif
                        </span>
                    </div>
                </div>

                <!-- Isi Laporan -->
                <div class="p-8">
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-8">

                        <!-- Kolom Kiri: Foto Laporan -->
                        <div class="md:col-span-1">
                            <p class="text-sm font-bold text-white/90 mb-3 text-center md:text-left">
                                Foto Bukti
                            </p>

                            @if($complaint->photo_path)
                                <a href="{{ asset('storage/' . $complaint->photo_path) }}" target="_blank">
                                    <img src="{{ asset('storage/' . $complaint->photo_path) }}"
                                         class="w-full h-40 object-cover rounded-2xl border-4 border-white/70 shadow-lg hover:scale-[1.02] transition duration-300">
                                </a>

                                <p class="text-[10px] text-white/50 mt-3 text-center italic">
                                    Klik gambar untuk memperbesar
                                </p>
                            @else
                                <div class="w-full h-40 bg-white/10 rounded-2xl flex flex-col items-center justify-center text-white/50 border-2 border-dashed border-white/20">
                                    <svg class="w-10 h-10 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                              d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z">
                                        </path>
                                    </svg>

                                    <span class="text-xs">
                                        Tidak ada foto
                                    </span>
                                </div>
                            @endif
                        </div>

                        <!-- Kolom Kanan: Konten Laporan -->
                        <div class="md:col-span-2">
                            <div class="mb-6">
                                <h1 class="text-2xl font-black text-white leading-tight mb-2">
                                    {{ $complaint->title }}
                                </h1>

                                <div class="flex flex-wrap items-center gap-4 text-sm text-white/70">
                                    <span class="flex items-center gap-1">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                  d="M7 7h.01M7 11h.01M7 15h.01M13 7h.01M13 11h.01M13 15h.01M17 7h.01M17 11h.01M17 15h.01">
                                            </path>
                                        </svg>

                                        {{ $complaint->category->name ?? 'Tanpa Kategori' }}
                                    </span>

                                    <span class="flex items-center gap-1">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                  d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z">
                                            </path>
                                        </svg>

                                        {{ $complaint->created_at->translatedFormat('d F Y, H:i') }}
                                    </span>
                                </div>
                            </div>

                            <div>
                                <p class="text-white/85 leading-relaxed whitespace-pre-line">
                                    {{ $complaint->description }}
                                </p>
                            </div>

                            @if($complaint->status->value == 'pending')
                                <div class="mt-8 p-4 bg-indigo-400/10 rounded-xl border border-indigo-300/20 flex items-start gap-3">
                                    <svg class="w-5 h-5 text-indigo-200 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                              d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z">
                                        </path>
                                    </svg>

                                    <p class="text-xs text-indigo-100 leading-normal">
                                        Laporan Anda sedang menunggu verifikasi oleh tim Front Office.
                                        Anda masih dapat mengubah atau membatalkan laporan ini melalui halaman utama.
                                    </p>
                                </div>
                            @endif
                        </div>
                    </div>

                    <!-- Bukti Penyelesaian -->
                    @if($complaint->status->value == 'resolved' && $completionHistory)
                        <div class="mt-10 rounded-3xl overflow-hidden border border-white/20 bg-white/10 backdrop-blur-xl shadow-xl">

                            <!-- Header Bukti Selesai -->
                            <div class="px-6 py-5 border-b border-white/10 bg-white/10">
                                <div class="flex items-center gap-4">
                                    <div class="w-11 h-11 rounded-2xl bg-emerald-400/20 border border-emerald-300/30 flex items-center justify-center shrink-0">
                                        <svg class="w-6 h-6 text-emerald-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                  d="M5 13l4 4L19 7">
                                            </path>
                                        </svg>
                                    </div>

                                    <div>
                                        <h3 class="text-xl font-black text-white">
                                            Laporan Selesai Dikerjakan
                                        </h3>

                                        <p class="text-sm text-white/65 mt-1">
                                            Berikut bukti pengerjaan dan keterangan dari petugas lapangan.
                                        </p>
                                    </div>
                                </div>
                            </div>

                            <!-- Isi Bukti Selesai -->
                            <div class="p-6 grid grid-cols-1 md:grid-cols-3 gap-8">

                                <!-- Foto Bukti Pengerjaan -->
                                <div class="md:col-span-1">
                                    <p class="text-sm font-bold text-white/90 mb-3 text-center md:text-left">
                                        Foto Bukti Pengerjaan
                                    </p>

                                    @if($completionHistory->action_photo_path)
                                        <a href="{{ asset('storage/' . $completionHistory->action_photo_path) }}" target="_blank">
                                            <img src="{{ asset('storage/' . $completionHistory->action_photo_path) }}"
                                                 class="w-full h-40 object-cover rounded-2xl border-4 border-white/70 shadow-lg hover:scale-[1.02] transition duration-300">
                                        </a>

                                        <p class="text-[10px] text-white/50 mt-3 text-center italic">
                                            Klik gambar untuk memperbesar
                                        </p>
                                    @else
                                        <div class="w-full h-40 bg-white/10 rounded-2xl flex items-center justify-center text-white/50 border-2 border-dashed border-white/20">
                                            <span class="text-xs">
                                                Tidak ada foto bukti
                                            </span>
                                        </div>
                                    @endif
                                </div>

                                <!-- Catatan Petugas -->
                                <div class="md:col-span-2">
                                    <p class="text-sm font-bold text-white/90 mb-3">
                                        Deskripsi / Catatan Petugas
                                    </p>

                                    <div class="bg-white/10 rounded-2xl p-5 border border-white/15 min-h-[110px]">
                                        <p class="text-white/80 text-sm leading-relaxed whitespace-pre-line">
                                            {{ $completionHistory->notes ?? 'Tidak ada catatan dari petugas.' }}
                                        </p>
                                    </div>

                                    <div class="mt-4 grid grid-cols-1 sm:grid-cols-2 gap-3">
                                        <div class="bg-white/10 rounded-2xl border border-white/15 p-4">
                                            <p class="text-[10px] font-black uppercase tracking-widest text-white/45 mb-1">
                                                Petugas
                                            </p>

                                            <p class="text-sm font-bold text-white">
                                                {{ $completionHistory->user->name ?? '-' }}
                                            </p>
                                        </div>

                                        <div class="bg-white/10 rounded-2xl border border-white/15 p-4">
                                            <p class="text-[10px] font-black uppercase tracking-widest text-white/45 mb-1">
                                                Tanggal Selesai
                                            </p>

                                            <p class="text-sm font-bold text-white">
                                                {{ $completionHistory->created_at->translatedFormat('d F Y, H:i') }}
                                            </p>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                    @endif

                </div>

                <!-- Footer Aksi -->
                <div class="px-8 py-6 bg-white/10 border-t border-white/10 flex justify-end gap-3">
                    @if($complaint->status->value == 'pending')
                        <a href="{{ route('warga.complaints.edit', $complaint) }}"
                           class="px-6 py-2 bg-white/15 border border-white/20 text-white font-bold text-xs rounded-xl hover:bg-white/25 transition shadow-sm">
                            Edit Laporan
                        </a>

                        <form action="{{ route('warga.complaints.destroy', $complaint) }}"
                              method="POST"
                              onsubmit="return confirm('Hapus laporan ini?')">
                            @csrf
                            @method('DELETE')

                            <button type="submit"
                                    class="px-6 py-2 bg-rose-500 text-white font-bold text-xs rounded-xl hover:bg-rose-600 transition shadow-lg shadow-rose-900/20">
                                Hapus
                            </button>
                        </form>
                    @endif
                </div>

            </div>
        </div>
    </div>
</x-app-layout>