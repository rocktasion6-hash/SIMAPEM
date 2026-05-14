<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Kirim Laporan Pengaduan') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white p-8 shadow-sm sm:rounded-lg">
                <form action="{{ route('warga.complaints.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    
                    <div class="space-y-6">
                        <!-- Judul -->
                        <div>
                            <label class="block text-sm font-bold text-gray-700">Judul Laporan</label>
                            <input type="text" name="title" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" placeholder="Contoh: Jalan Berlubang di RT 01" required>
                        </div>

                        <!-- Deskripsi -->
                        <div>
                            <label class="block text-sm font-bold text-gray-700">Isi Laporan / Deskripsi</label>
                            <textarea name="description" rows="5" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" placeholder="Jelaskan detail masalah..." required></textarea>
                        </div>

                        <!-- Upload Foto -->
                        <div>
                            <label class="block text-sm font-bold text-gray-700">Foto Bukti</label>
                            <input type="file" name="photo" class="mt-1 block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100" required>
                        </div>

                        <!-- Lokasi (Latitude & Longitude) -->
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-bold text-gray-700">Latitude</label>
                                <input type="text" name="latitude" id="lat" class="mt-1 block w-full rounded-md border-gray-300 bg-gray-50 shadow-sm" readonly required>
                            </div>
                            <div>
                                <label class="block text-sm font-bold text-gray-700">Longitude</label>
                                <input type="text" name="longitude" id="lng" class="mt-1 block w-full rounded-md border-gray-300 bg-gray-50 shadow-sm" readonly required>
                            </div>
                        </div>
                        <button type="button" onclick="getLocation()" class="text-xs text-indigo-600 font-bold hover:underline">
                            [ Ambil Lokasi Saya Otomatis ]
                        </button>
                    </div>

                    <div class="mt-8 flex justify-end gap-4 border-t pt-6">
                        <a href="{{ route('warga.complaints.index') }}" class="px-4 py-2 text-gray-600">Batal</a>
                        <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-2 px-8 rounded-lg shadow-lg transition">
                            Kirim Laporan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- SCRIPT AMBIL LOKASI -->
    <script>
        function getLocation() {
            if (navigator.geolocation) {
                navigator.geolocation.getCurrentPosition(function(position) {
                    document.getElementById('lat').value = position.coords.latitude;
                    document.getElementById('lng').value = position.coords.longitude;
                }, function(error) {
                    alert("Gagal mengambil lokasi. Pastikan izin GPS aktif.");
                });
            } else {
                alert("Browser Anda tidak mendukung deteksi lokasi.");
            }
        }
    </script>
</x-app-layout>