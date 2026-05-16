<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Daftar Tugas Lapangan') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                
                @if(session('success'))
                    <div class="mb-4 p-4 bg-green-100 text-green-700 rounded-lg">
                        {{ session('success') }}
                    </div>
                @endif

                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @forelse ($tasks as $task)
                        <div class="border rounded-xl overflow-hidden shadow-sm hover:shadow-md transition">
                            <!-- Foto Laporan Awal -->
                            <img src="{{ asset('storage/' . $task->photo_path) }}" class="w-full h-48 object-cover" alt="Foto Laporan">
                            
                            <div class="p-4">
                                <div class="flex justify-between items-start mb-2">
                                    <span class="text-xs font-bold text-sky-300 bg-white/10 px-2 py-1 rounded">
                                        {{ $task->tracking_code }}
                                    </span>
                                    <span class="text-xs px-2 py-1 rounded {{ $task->status->value == 'in_progress' ? 'bg-yellow-100 text-yellow-800' : 'bg-purple-100 text-purple-800' }}">
                                        {{ ucfirst($task->status->value) }}
                                    </span>
                                </div>
                                
                                <h3 class="font-bold text-white mb-1">{{ $task->title }}</h3>
                                <p class="text-sm text-slate-200 line-clamp-2 mb-4">{{ $task->description }}</p>
                                
                                <div class="flex items-center gap-2 mb-4 text-xs text-slate-300">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                                    <a href="https://www.google.com/maps?q={{ $task->latitude }},{{ $task->longitude }}" target="_blank" class="hover:underline">Buka Lokasi (Maps)</a>
                                </div>

                                <a href="{{ route('pelaksana.tasks.show', $task->id) }}" 
                                   class="block w-full text-center bg-indigo-600 hover:bg-indigo-700 text-white font-semibold py-2 rounded-lg transition">
                                    Update Progress
                                </a>
                            </div>
                        </div>
                    @empty
                        <div class="col-span-full text-center py-10">
                            <p class="text-gray-400">Belum ada tugas yang diberikan untuk Anda.</p>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</x-app-layout>