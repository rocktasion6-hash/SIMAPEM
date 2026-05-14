<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Laporan Saya') }}
            </h2>
            <a href="{{ route('warga.complaints.create') }}" class="bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded-lg text-sm font-bold transition shadow-lg shadow-indigo-200">
                + Buat Laporan
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            <!-- Notifikasi Sukses -->
            @if(session('success'))
                <div class="mb-6 p-4 bg-green-50 border-l-4 border-green-500 text-green-700 rounded-r-lg shadow-sm flex items-center">
                    <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                    </svg>
                    <span class="font-medium">{{ session('success') }}</span>
                </div>
            @endif

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-xl p-6">
                <div class="grid grid-cols-1 gap-6">
                    @forelse ($complaints as $item)
                        <div class="border border-gray-100 rounded-2xl p-5 flex flex-col md:flex-row gap-6 hover:border-indigo-200 hover:shadow-xl hover:shadow-indigo-50/50 transition duration-300">
                            
                            <!-- Foto Laporan -->
                            <div class="shrink-0">
                                @if($item->photo_path)
                                    <img src="{{ asset('storage/' . $item->photo_path) }}" class="w-full md:w-40 h-40 object-cover rounded-xl border border-gray-100 shadow-sm">
                                @else
                                    <div class="w-full md:w-40 h-40 bg-gray-100 rounded-xl flex items-center justify-center text-gray-400">
                                        <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                        </svg>
                                    </div>
                                @endif
                            </div>
                            
                            <div class="flex-1 flex flex-col">
                                <div class="flex justify-between items-start mb-2">
                                    <div>
                                        <span class="text-[10px] font-mono px-2 py-1 bg-gray-100 text-gray-500 rounded uppercase tracking-wider">{{ $item->tracking_code }}</span>
                                        <h3 class="font-bold text-xl text-gray-800 mt-1">{{ $item->title }}</h3>
                                    </div>
                                    
                                    <!-- Badge Status -->
                                    <span class="px-3 py-1 rounded-full text-[10px] font-black uppercase tracking-widest
                                        @if($item->status->value == 'pending') bg-amber-100 text-amber-700
                                        @elseif($item->status->value == 'resolved') bg-emerald-100 text-emerald-700
                                        @elseif($item->status->value == 'rejected') bg-rose-100 text-rose-700
                                        @else bg-blue-100 text-blue-700 @endif">
                                        {{ $item->status->value }}
                                    </span>
                                </div>

                                <p class="text-sm text-gray-600 line-clamp-2 mb-4">{{ $item->description }}</p>
                                
                                <div class="mt-auto flex flex-wrap items-center justify-between gap-4 border-t border-gray-50 pt-4">
                                    <!-- Tombol Aksi -->
                                    <div class="flex items-center gap-2">
                                        <a href="{{ route('warga.complaints.show', $item) }}" class="inline-flex items-center px-3 py-1.5 bg-gray-50 hover:bg-gray-200 text-gray-700 text-xs font-bold rounded-lg transition duration-200">
                                            Lihat Detail
                                        </a>

                                        @if($item->status->value == 'pending')
                                            <a href="{{ route('warga.complaints.edit', $item) }}" class="inline-flex items-center px-3 py-1.5 bg-indigo-50 hover:bg-indigo-100 text-indigo-700 text-xs font-bold rounded-lg transition duration-200">
                                                Edit
                                            </a>

                                            <form action="{{ route('warga.complaints.destroy', $item) }}" method="POST" onsubmit="return confirm('Hapus laporan ini?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="inline-flex items-center px-3 py-1.5 bg-rose-50 hover:bg-rose-100 text-rose-700 text-xs font-bold rounded-lg transition duration-200">
                                                    Hapus
                                                </button>
                                            </form>
                                        @endif
                                    </div>

                                    <div class="text-[11px] text-gray-400">
                                        <span class="font-medium">Dikirim:</span> {{ $item->created_at->translatedFormat('d M Y, H:i') }}
                                    </div>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="text-center py-20 bg-gray-50 rounded-2xl border-2 border-dashed border-gray-200">
                            <div class="bg-white w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-4 shadow-sm">
                                <svg class="w-8 h-8 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                </svg>
                            </div>
                            <h3 class="text-gray-600 font-bold">Belum Ada Laporan</h3>
                            <p class="text-gray-400 text-sm mt-1">Laporan yang Anda kirim akan muncul di sini.</p>
                            <a href="{{ route('warga.complaints.create') }}" class="mt-4 inline-block text-indigo-600 font-bold text-sm hover:underline">Buat laporan pertama Anda &rarr;</a>
                        </div>
                    @endforelse
                </div>

                <!-- Pagination (Jika Ada) -->
                @if(method_exists($complaints, 'links'))
                    <div class="mt-8">
                        {{ $complaints->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>