<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Verifikasi Laporan Masuk') }}
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

                <div class="overflow-x-auto">
                    <table class="w-full text-sm text-left text-gray-500">
                        <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                            <tr>
                                <th class="px-6 py-3">Kode</th>
                                <th class="px-6 py-3">Pelapor</th>
                                <th class="px-6 py-3">Judul Laporan</th>
                                <th class="px-6 py-3">Tanggal</th>
                                <th class="px-6 py-3 text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($complaints as $item)
                                <tr class="bg-white border-b hover:bg-gray-50">
                                    <td class="px-6 py-4 font-bold text-blue-600">{{ $item->tracking_code }}</td>
                                    <td class="px-6 py-4">{{ $item->user->name }}</td>
                                    <td class="px-6 py-4">{{ $item->title }}</td>
                                    <td class="px-6 py-4">{{ $item->created_at->format('d M Y') }}</td>
                                    <td class="px-6 py-4 text-center">
                                        <!-- Tombol untuk memicu Modal -->
                                        <button onclick="openModal('{{ $item->id }}', '{{ $item->title }}', `{{ asset('storage/' . $item->photo_path) }}`)"
                                                class="bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded-md transition text-xs">
                                            Verifikasi
                                        </button>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="px-6 py-10 text-center text-gray-400">Tidak ada laporan pending.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="mt-4">
                    {{ $complaints->links() }}
                </div>
            </div>
        </div>
    </div>

    <!-- MODAL VERIFIKASI -->
    <div id="modalVerif" class="fixed inset-0 bg-black bg-opacity-50 hidden z-50 flex items-center justify-center">
        <div class="bg-white rounded-lg w-full max-w-2xl p-6 overflow-y-auto max-h-[90vh]">
            <h3 class="text-lg font-bold mb-4 border-b pb-2">Detail Verifikasi Laporan</h3>
            
            <form id="formVerif" method="POST" action="">
                @csrf
                @method('PATCH')
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <!-- Foto Laporan -->
                    <div>
                        <p class="text-xs text-gray-500 mb-1">Foto Bukti:</p>
                        <img id="modalImg" src="" alt="Bukti" class="rounded-lg w-full object-cover border h-48">
                    </div>

                    <!-- Input Data -->
                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Tentukan Kategori</label>
                            <select name="category_id" id="category_id" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                <option value="">-- Pilih Kategori --</option>
                                @foreach($categories as $cat)
                                    <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700">Status Tindakan</label>
                            <select name="status" id="status" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>
                                <option value="verified">Terima (Verifikasi)</option>
                                <option value="rejected">Tolak Laporan</option>
                            </select>
                        </div>
                    </div>
                </div>

                <div class="mt-4">
                    <label class="block text-sm font-medium text-gray-700">Catatan/Alasan (Opsional)</label>
                    <textarea name="notes" rows="3" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" placeholder="Berikan catatan tambahan jika diperlukan..."></textarea>
                </div>

                <div class="mt-6 flex justify-end space-x-3">
                    <button type="button" onclick="closeModal()" class="px-4 py-2 bg-rose-100 text-rose-700 rounded-md hover:bg-rose-200 transition">Batal</button>
                    <button type="submit" class="px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700 transition">Simpan Perubahan</button>
                </div>
            </form>
        </div>
    </div>

    <!-- SCRIPT UNTUK MODAL -->
    <script>
        function openModal(id, title, imgUrl) {
            const modal = document.getElementById('modalVerif');
            const form = document.getElementById('formVerif');
            const img = document.getElementById('modalImg');
            
            // Set URL action form secara dinamis
            form.action = `/fo/verifikasi/${id}`;
            img.src = imgUrl;
            
            modal.classList.remove('hidden');
        }

        function closeModal() {
            document.getElementById('modalVerif').classList.add('hidden');
        }
    </script>
</x-app-layout>