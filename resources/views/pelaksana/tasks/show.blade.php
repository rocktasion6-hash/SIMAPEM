<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Update Progress Tugas') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white p-6 shadow-sm sm:rounded-lg">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-8">
                    <!-- Detail Laporan -->
                    <div>
                        <h3 class="text-lg font-bold mb-4 border-b border-white/20 pb-2 text-white">Informasi Laporan</h3>
                        <div class="space-y-3 text-sm text-slate-200">
                            <p><span class="font-semibold">Judul:</span> {{ $complaint->title }}</p>
                            <p><span class="font-semibold">Kategori:</span> {{ $complaint->category->name }}</p>
                            <p><span class="font-semibold">Deskripsi:</span> {{ $complaint->description }}</p>
                            <p><span class="font-semibold">Pelapor:</span> {{ $complaint->user->name }}</p>
                        </div>
                    </div>
                    <!-- Foto Awal -->
                    <div>
                        <h3 class="text-lg font-bold mb-4 border-b border-white/20 pb-2 text-white">Foto Lokasi</h3>
                        <img src="{{ asset('storage/' . $complaint->photo_path) }}" class="rounded-lg shadow border w-full h-48 object-cover">
                    </div>
                </div>

                <hr class="my-8">

                <!-- Form Update -->
                <form action="{{ route('pelaksana.tasks.update', $complaint->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PATCH')
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-medium text-slate-200">Status Terbaru</label>
                            <select name="status" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500" required>
                                <option value="in_progress" {{ $complaint->status->value == 'in_progress' ? 'selected' : '' }}>Sedang Dikerjakan (In Progress)</option>
                                <option value="resolved" {{ $complaint->status->value == 'resolved' ? 'selected' : '' }}>Selesai (Resolved)</option>
                            </select>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-slate-200">Foto Bukti Pekerjaan (Wajib jika Selesai)</label>
                            <input type="file" name="action_photo" class="mt-1 block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100">
                        </div>
                    </div>

                    <div class="mt-6">
                        <label class="block text-sm font-medium text-slate-200">Catatan Tindakan</label>
                        <textarea name="notes" rows="4" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500" placeholder="Jelaskan apa yang sudah dilakukan di lapangan..."></textarea>
                    </div>

                    <div class="mt-8 flex justify-end gap-3">
                        <a href="{{ route('pelaksana.tasks.index') }}" class="px-4 py-2 bg-white/10 text-slate-200 rounded-lg hover:bg-white/20 transition">Kembali</a>
                        <button type="submit" class="px-6 py-2 bg-indigo-600 text-white font-bold rounded-lg hover:bg-indigo-700 transition">
                            Simpan Update
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>