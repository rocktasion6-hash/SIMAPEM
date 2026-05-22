<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-900 leading-tight">
                Detail Laporan
            </h2>

            <a href="{{ route('kadis.complaints.index') }}"
               class="text-sm font-bold text-blue-600 hover:text-blue-800 transition">
                &larr; Kembali ke Daftar
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8 space-y-6">

            <!-- Info Utama -->
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

                        <span class="px-4 py-1.5 rounded-full text-xs font-black uppercase tracking-widest border
                            @if($complaint->status->value == 'pending')
                                bg-amber-400/20 text-amber-200 border-amber-300/30
                            @elseif($complaint->status->value == 'resolved')
                                bg-emerald-400/20 text-emerald-200 border-emerald-300/30
                            @elseif($complaint->status->value == 'rejected')
                                bg-rose-400/20 text-rose-200 border-rose-300/30
                            @else
                                bg-blue-400/20 text-blue-200 border-blue-300/30
                            @endif">

                            @if($complaint->status->value == 'pending')
                                Menunggu
                            @elseif($complaint->status->value == 'resolved')
                                Selesai
                            @elseif($complaint->status->value == 'rejected')
                                Ditolak
                            @else
                                {{ ucfirst($complaint->status->value) }}
                            @endif
                        </span>
                    </div>
                </div>

                <!-- Isi Laporan -->
                <div class="p-8">
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-8">

                        <!-- Foto Laporan -->
                        <div class="md:col-span-1">
                            <p class="text-sm font-bold text-white/90 mb-3 text-center md:text-left">
                                Foto Laporan
                            </p>

                            @if($complaint->photo_path)
                                <a href="{{ asset('storage/' . $complaint->photo_path) }}" target="_blank">
                                    <img src="{{ asset('storage/' . $complaint->photo_path) }}"
                                         class="w-full h-40 object-cover rounded-2xl border-4 border-white/70 shadow-lg hover:scale-[1.02] transition duration-300"
                                         alt="Foto Laporan">
                                </a>

                                <p class="text-[10px] text-white/50 mt-3 text-center italic">
                                    Klik gambar untuk memperbesar
                                </p>
                            @else
                                <div class="w-full h-40 bg-white/10 rounded-2xl flex items-center justify-center text-white/50 border-2 border-dashed border-white/20">
                                    <span class="text-xs">
                                        Tidak ada foto
                                    </span>
                                </div>
                            @endif
                        </div>

                        <!-- Detail Laporan -->
                        <div class="md:col-span-2">
                            <div class="mb-6">
                                <h1 class="text-2xl font-black text-white leading-tight mb-2">
                                    {{ $complaint->title }}
                                </h1>

                                <div class="flex flex-wrap items-center gap-3 text-sm text-white/70">

                                    <span class="inline-flex items-center gap-2 px-3 py-1.5 bg-white/10 rounded-full border border-white/10">
                                        Pelapor:
                                        <span class="font-bold text-white">
                                            {{ $complaint->user->name }}
                                        </span>
                                    </span>

                                    <span class="inline-flex items-center gap-2 px-3 py-1.5 bg-white/10 rounded-full border border-white/10">
                                        Kategori:
                                        <span class="font-bold text-white">
                                            {{ $complaint->category?->name ?? '-' }}
                                        </span>
                                    </span>

                                </div>
                            </div>

                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 mb-6">
                                <div class="bg-white/10 rounded-2xl border border-white/15 p-4">
                                    <p class="text-[10px] font-black uppercase tracking-widest text-white/45 mb-1">
                                        Tanggal
                                    </p>

                                    <p class="text-sm font-bold text-white">
                                        {{ $complaint->created_at->translatedFormat('d M Y, H:i') }}
                                    </p>
                                </div>

                                <div class="bg-white/10 rounded-2xl border border-white/15 p-4">
                                    <p class="text-[10px] font-black uppercase tracking-widest text-white/45 mb-1">
                                        Petugas
                                    </p>

                                    <p class="text-sm font-bold text-white">
                                        {{ $complaint->assignedTo?->name ?? 'Belum ditugaskan' }}
                                    </p>
                                </div>
                            </div>

                            @if($complaint->latitude)
                                <div class="mb-6 bg-blue-400/10 rounded-2xl border border-blue-300/20 p-4">
                                    <p class="text-[10px] font-black uppercase tracking-widest text-white/45 mb-2">
                                        Lokasi
                                    </p>

                                    <a href="https://www.google.com/maps?q={{ $complaint->latitude }},{{ $complaint->longitude }}"
                                       target="_blank"
                                       class="inline-flex items-center px-4 py-2 bg-[#0077B6] hover:bg-[#006494] text-white text-xs font-bold rounded-xl transition">
                                        Lihat di Maps
                                    </a>
                                </div>
                            @endif

                            <div class="bg-white/10 rounded-2xl p-5 border border-white/15">
                                <p class="text-[10px] font-black uppercase tracking-widest text-white/45 mb-2">
                                    Deskripsi
                                </p>

                                <p class="text-white/80 text-sm leading-relaxed whitespace-pre-line">
                                    {{ $complaint->description }}
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Riwayat -->
            @if($complaint->histories->count())
                <div class="bg-black/35 backdrop-blur-xl overflow-hidden shadow-2xl sm:rounded-3xl border border-white/20 text-white">

                    <!-- Header Riwayat -->
                    <div class="p-6 border-b border-white/10 bg-white/10">
                        <div class="flex items-center gap-4">
                            <div class="w-11 h-11 rounded-2xl bg-blue-400/20 border border-blue-300/30 flex items-center justify-center shrink-0">
                                <svg class="w-6 h-6 text-blue-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round"
                                          stroke-linejoin="round"
                                          stroke-width="2"
                                          d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z">
                                    </path>
                                </svg>
                            </div>

                            <div>
                                <h4 class="text-xl font-black text-white">
                                    Riwayat Tindakan
                                </h4>

                                <p class="text-sm text-white/60 mt-1">
                                    Semua proses tindakan pada laporan ini.
                                </p>
                            </div>
                        </div>
                    </div>

                    <div class="p-6 space-y-5">
                        @foreach($complaint->histories->sortByDesc('created_at') as $history)
                            <div class="relative border-l-2 border-blue-300/50 pl-5 pb-2">

                                <div class="absolute -left-[7px] top-1 w-3 h-3 rounded-full bg-blue-300 border-2 border-white/50"></div>

                                <div class="bg-white/10 rounded-2xl border border-white/15 p-5">

                                    <div class="flex flex-col sm:flex-row sm:justify-between sm:items-center gap-2 mb-3">
                                        <span class="w-fit px-3 py-1 rounded-full text-[10px] font-black uppercase tracking-widest border bg-blue-400/20 text-blue-200 border-blue-300/30">
                                            {{ $history->status ?? '-' }}
                                        </span>

                                        <span class="text-xs text-white/45">
                                            {{ $history->created_at->translatedFormat('d M Y, H:i') }}
                                        </span>
                                    </div>

                                    @if($history->user)
                                        <p class="text-xs text-white/55 mb-2">
                                            Oleh:
                                            <span class="font-bold text-white/80">
                                                {{ $history->user->name }}
                                            </span>
                                        </p>
                                    @endif

                                    @if($history->notes)
                                        <p class="text-sm text-white/80 leading-relaxed whitespace-pre-line">
                                            {{ $history->notes }}
                                        </p>
                                    @else
                                        <p class="text-sm text-white/45 italic">
                                            Tidak ada catatan.
                                        </p>
                                    @endif

                                    @if($history->action_photo_path)
                                        <div class="mt-4">
                                            <p class="text-xs font-bold text-white/60 mb-2">
                                                Foto Bukti Tindakan:
                                            </p>

                                            <a href="{{ asset('storage/' . $history->action_photo_path) }}" target="_blank">
                                                <img src="{{ asset('storage/' . $history->action_photo_path) }}"
                                                     class="rounded-2xl w-40 h-40 object-cover border-4 border-white/60 shadow-lg hover:scale-[1.02] transition duration-300"
                                                     alt="Foto Tindakan">
                                            </a>
                                        </div>
                                    @endif

                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif

        </div>
    </div>
</x-app-layout>