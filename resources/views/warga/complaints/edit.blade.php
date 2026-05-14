<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Laporan Pengaduan') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white p-8 shadow-sm sm:rounded-lg">
                <!-- Gunakan method PATCH untuk update data -->
                <form action="{{ route('warga.complaints.update', $complaint) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    
                    <div class="space-y-6">
                        <!-- Judul -->
                        <div>
                            <label class="block text-sm font-bold text-gray-700">Judul Laporan</label>
                            <input type="text" name="title" value="{{ old('title', $complaint->title) }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" placeholder="Contoh: Jalan Berlubang di RT 01" required>
                            @error('title') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>

                        <!-- Deskripsi -->
                        <div>
                            <label class="block text-sm font-bold text-gray-700">Isi Laporan / Deskripsi</label>
                            <textarea name="description" rows="5" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" placeholder="Jelaskan detail masalah..." required>{{ old('description', $complaint->description) }}</textarea>
                            @error('description') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>

                        <!-- Upload Foto -->
                        <div>
                            <label class="block text-sm font-bold text-gray-700">Foto Bukti</label>
                            
                            <!-- Menampilkan foto lama jika ada -->
                            @if($complaint->photo_path)
                                <div class="mb-3 mt-2">
                                    <p class="text-xs text-gray-500 mb-1">Foto saat ini:</p>
                                    <img src="{{ asset('storage/' . $complaint->photo_path) }}" class="w-32 h-32 object-cover rounded-lg border border-gray-200">
                                </div>
                            @endif

                            <input type="file" name="photo" class="mt-1 block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100">
                            <p class="text-[10px] text-gray-400 mt-1 italic">*Kosongkan jika tidak ingin mengganti foto</p>
                            @error('photo') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>

                        <!-- Lokasi (Latitude & Longitude) -->
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-bold text-gray-700">Latitude</label>
                                <input type="text" name="latitude" id="lat" value="{{ old('latitude', $complaint->latitude) }}" class="mt-1 block w-full rounded-md border-gray-300 bg-gray-50 shadow-sm" readonly required>
                            </div>
                            <div>
                                <label class="block text-sm font-bold text-gray-700">Longitude</label>
                                <input type="text" name="longitude" id="lng" value="{{ old('longitude', $complaint->longitude) }}" class="mt-1 block w-full rounded-md border-gray-300 bg-gray-50 shadow-sm" readonly required>
                            </div>
                        </div>
                        <button type="button" onclick="getLocation()" class="text-xs text-indigo-600 font-bold hover:underline">
                            [ Perbarui Lokasi Saya Otomatis ]
                        </button>
                    </div>

                    <div class="mt-8 flex justify-end gap-4 border-t pt-6">
                        <a href="{{ route('warga.complaints.index') }}" class="px-4 py-2 text-gray-600">Batal</a>
                        <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-2 px-8 rounded-lg shadow-lg transition">
                            Simpan Perubahan
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