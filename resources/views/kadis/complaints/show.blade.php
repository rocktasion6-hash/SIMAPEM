<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Detail Laporan
            </h2>
            <a href="{{ route('kadis.complaints.index') }}" class="text-sm text-sky-300 hover:underline">
                &larr; Kembali ke Daftar
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8 space-y-6">

            <!-- Info Utama -->
            <div class="bg-white p-6 rounded-xl shadow-sm">
                <div class="flex justify-between items-start mb-4">
                    <div>
                        <span class="text-xs font-mono text-sky-300">{{ $complaint->tracking_code }}</span>
                        <h3 class="text-xl font-bold text-white mt-1">{{ $complaint->title }}</h3>
                    </div>
                    <span class="px-3 py-1 rounded-full text-xs font-bold
                        @if($complaint->status->value == 'pending') bg-amber-100 text-amber-700
                        @elseif($complaint->status->value == 'resolved') bg-emerald-100 text-emerald-700
                        @elseif($complaint->status->value == 'rejected') bg-rose-100 text-rose-700
                        @else bg-blue-100 text-blue-700 @endif">
                        {{ ucfirst($complaint->status->value) }}
                    </span>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="space-y-3 text-sm text-slate-200">
                        <p><span class="font-semibold text-white">Pelapor:</span> {{ $complaint->user->name }}</p>
                        <p><span class="font-semibold text-white">Kategori:</span> {{ $complaint->category?->name ?? '-' }}</p>
                        <p><span class="font-semibold text-white">Tanggal:</span> {{ $complaint->created_at->format('d M Y, H:i') }}</p>
                        <p><span class="font-semibold text-white">Petugas:</span> {{ $complaint->assignedTo?->name ?? 'Belum ditugaskan' }}</p>
                        @if($complaint->latitude)
                            <p>
                                <span class="font-semibold text-white">Lokasi:</span>
                                <a href="https://www.google.com/maps?q={{ $complaint->latitude }},{{ $complaint->longitude }}"
                                   target="_blank" class="text-sky-300 hover:underline">Lihat di Maps</a>
                            </p>
                        @endif
                        <div>
                            <span class="font-semibold text-white">Deskripsi:</span>
                            <p class="mt-1 text-slate-300">{{ $complaint->description }}</p>
                        </div>
                    </div>

                    <div>
                        @if($complaint->photo_path)
                            <img src="{{ asset('storage/' . $complaint->photo_path) }}"
                                 class="rounded-lg w-full h-52 object-cover border border-white/20" alt="Foto Laporan">
                        @else
                            <div class="w-full h-52 bg-white/10 rounded-lg flex items-center justify-center text-slate-400 text-sm">
                                Tidak ada foto
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Riwayat -->
            @if($complaint->histories->count())
                <div class="bg-white p-6 rounded-xl shadow-sm">
                    <h4 class="font-bold text-white mb-4">Riwayat Tindakan</h4>
                    <div class="space-y-4">
                        @foreach($complaint->histories->sortByDesc('created_at') as $history)
                            <div class="border-l-2 border-sky-400 pl-4">
                                <div class="flex justify-between items-center">
                                    <span class="text-xs font-bold text-sky-300 uppercase">{{ $history->status ?? '-' }}</span>
                                    <span class="text-xs text-slate-400">{{ $history->created_at->format('d M Y, H:i') }}</span>
                                </div>
                                @if($history->notes)
                                    <p class="text-sm text-slate-200 mt-1">{{ $history->notes }}</p>
                                @endif
                                @if($history->action_photo_path)
                                    <img src="{{ asset('storage/' . $history->action_photo_path) }}"
                                         class="mt-2 rounded-lg h-32 object-cover border border-white/20">
                                @endif
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif

        </div>
    </div>
</x-app-layout>
