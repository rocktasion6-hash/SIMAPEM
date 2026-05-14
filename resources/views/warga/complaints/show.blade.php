<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Detail Laporan') }}
            </h2>
            <a href="{{ route('warga.complaints.index') }}" class="text-sm font-bold text-indigo-600 hover:text-indigo-800 transition">
                &larr; Kembali ke Daftar
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-2xl">
                
                <!-- Status Header -->
                <div class="p-8 border-b border-gray-50 bg-gray-50/50 flex flex-wrap justify-between items-center gap-4">
                    <div>
                        <p class="text-[10px] font-black uppercase tracking-[0.2em] text-gray-400">Kode Tracking</p>
                        <h3 class="text-lg font-mono font-bold text-indigo-600">{{ $complaint->tracking_code }}</h3>
                    </div>
                    <div class="text-right">
                        <p class="text-[10px] font-black uppercase tracking-[0.2em] text-gray-400 mb-1">Status Saat Ini</p>
                        <span class="px-4 py-1.5 rounded-full text-xs font-black uppercase tracking-widest
                            @if($complaint->status->value == 'pending') bg-amber-100 text-amber-700
                            @elseif($complaint->status->value == 'resolved') bg-emerald-100 text-emerald-700
                            @elseif($complaint->status->value == 'rejected') bg-rose-100 text-rose-700
                            @else bg-blue-100 text-blue-700 @endif">
                            {{ $complaint->status->value }}
                        </span>
                    </div>
                </div>

                <div class="p-8">
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                        
                        <!-- Kolom Kiri: Foto -->
                        <div class="md:col-span-1">
                            <p class="text-sm font-bold text-gray-700 mb-3 text-center md:text-left">Foto Bukti</p>
                            @if($complaint->photo_path)
                                <a href="{{ asset('storage/' . $complaint->photo_path) }}" target="_blank">
                                    <img src="{{ asset('storage/' . $complaint->photo_path) }}" 
                                         class="w-full h-auto object-cover rounded-2xl border-4 border-white shadow-lg hover:scale-[1.02] transition duration-300">
                                </a>
                                <p class="text-[10px] text-gray-400 mt-3 text-center italic">Klik gambar untuk memperbesar</p>
                            @else
                                <div class="w-full aspect-square bg-gray-100 rounded-2xl flex flex-col items-center justify-center text-gray-400 border-2 border-dashed border-gray-200">
                                    <svg class="w-12 h-12 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                    </svg>
                                    <span class="text-xs">Tidak ada foto</span>
                                </div>
                            @endif
                        </div>

                        <!-- Kolom Kanan: Konten -->
                        <div class="md:col-span-2">
                            <div class="mb-6">
                                <h1 class="text-2xl font-black text-gray-900 leading-tight mb-2">{{ $complaint->title }}</h1>
                                <div class="flex items-center gap-4 text-sm text-gray-500">
                                    <span class="flex items-center gap-1">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 11h.01M7 15h.01M13 7h.01M13 11h.01M13 15h.01M17 7h.01M17 11h.01M17 15h.01"></path></svg>
                                        {{ $complaint->category->name ?? 'Tanpa Kategori' }}
                                    </span>
                                    <span class="flex items-center gap-1">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                        {{ $complaint->created_at->translatedFormat('d F Y, H:i') }}
                                    </span>
                                </div>
                            </div>

                            <div class="prose prose-indigo max-w-none">
                                <p class="text-gray-700 leading-relaxed whitespace-pre-line">
                                    {{ $complaint->description }}
                                </p>
                            </div>

                            @if($complaint->status->value == 'pending')
                                <div class="mt-8 p-4 bg-indigo-50 rounded-xl border border-indigo-100 flex items-start gap-3">
                                    <svg class="w-5 h-5 text-indigo-500 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                    <p class="text-xs text-indigo-700 leading-normal">
                                        Laporan Anda sedang menunggu verifikasi oleh tim Front Office. Anda masih dapat mengubah atau membatalkan laporan ini melalui halaman utama.
                                    </p>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Footer Aksi -->
                <div class="px-8 py-6 bg-gray-50 border-t border-gray-100 flex justify-end gap-3">
                    @if($complaint->status->value == 'pending')
                        <a href="{{ route('warga.complaints.edit', $complaint) }}" class="px-6 py-2 bg-white border border-gray-200 text-gray-700 font-bold text-xs rounded-xl hover:bg-gray-100 transition shadow-sm">
                            Edit Laporan
                        </a>
                        <form action="{{ route('warga.complaints.destroy', $complaint) }}" method="POST" onsubmit="return confirm('Hapus laporan ini?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="px-6 py-2 bg-rose-500 text-white font-bold text-xs rounded-xl hover:bg-rose-600 transition shadow-lg shadow-rose-100">
                                Hapus
                            </button>
                        </form>
                    @endif
                </div>

            </div>
        </div>
    </div>
</x-app-layout>