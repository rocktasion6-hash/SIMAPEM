<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Penugasan Petugas Lapangan') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                
                @if(session('success'))
                    <div class="mb-4 p-4 bg-blue-100 text-blue-700 rounded-lg">
                        {{ session('success') }}
                    </div>
                @endif

                <div class="overflow-x-auto">
                    <table class="w-full text-sm text-left text-gray-500">
                        <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                            <tr>
                                <th class="px-6 py-3">Kode</th>
                                <th class="px-6 py-3">Kategori</th>
                                <th class="px-6 py-3">Judul Laporan</th>
                                <th class="px-6 py-3">Lokasi</th>
                                <th class="px-6 py-3 text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($complaints as $item)
                                <tr class="bg-white border-b hover:bg-gray-50">
                                    <td class="px-6 py-4 font-bold text-sky-300">{{ $item->tracking_code }}</td>
                                    <td class="px-6 py-4">
                                        <span class="px-2 py-1 bg-blue-100 text-blue-800 rounded text-xs">
                                            {{ $item->category->name }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4">{{ $item->title }}</td>
                                    <td class="px-6 py-4">
                                        <a href="https://www.google.com/maps?q={{ $item->latitude }},{{ $item->longitude }}" 
                                           target="_blank" class="text-sky-300 hover:underline flex items-center gap-1 text-xs">
                                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                                            Lihat Map
                                        </a>
                                    </td>
                                    <td class="px-6 py-4 text-center">
                                        <button onclick="openAssignModal('{{ $item->id }}', '{{ $item->title }}')" 
                                                class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-md text-xs transition">
                                            Tugaskan
                                        </button>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="px-6 py-10 text-center text-gray-400">Semua laporan sudah diproses.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- MODAL PENUGASAN -->
    <div id="modalAssign" class="fixed inset-0 bg-black bg-opacity-50 hidden z-50 flex items-center justify-center">
        <div class="bg-white rounded-lg w-full max-w-md p-6 shadow-2xl">
            <h3 class="text-lg font-bold mb-2">Pilih Petugas</h3>
            <p id="assignTitle" class="text-sm text-gray-500 mb-6 italic"></p>
            
            <form id="formAssign" method="POST" action="">
                @csrf
                <div class="mb-6">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Nama Petugas Pelaksana</label>
                    <select name="assigned_to" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-green-500 focus:ring-green-500" required>
                        <option value="">-- Pilih Petugas Lapangan --</option>
                        @foreach($officers as $officer)
                            <option value="{{ $officer->id }}">{{ $officer->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="flex justify-end space-x-3 border-t pt-4">
                    <button type="button" onclick="closeAssignModal()" class="px-4 py-2 bg-gray-100 text-gray-700 rounded-md hover:bg-gray-200 transition">Batal</button>
                    <button type="submit" class="px-4 py-2 bg-green-600 text-white rounded-md hover:bg-green-700 transition font-semibold">Kirim Tugas</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        function openAssignModal(id, title) {
            const modal = document.getElementById('modalAssign');
            const form = document.getElementById('formAssign');
            const titleDisplay = document.getElementById('assignTitle');
            
            // Set action URL secara dinamis (sesuai route kasi.assignment.store)
            form.action = `/kasi/assignment/${id}`;
            titleDisplay.innerText = "Tugaskan untuk: " + title;
            
            modal.classList.remove('hidden');
        }

        function closeAssignModal() {
            document.getElementById('modalAssign').classList.add('hidden');
        }

        // Tutup modal jika klik di luar area modal
        window.onclick = function(event) {
            const modal = document.getElementById('modalAssign');
            if (event.target == modal) {
                closeAssignModal();
            }
        }
    </script>
</x-app-layout>