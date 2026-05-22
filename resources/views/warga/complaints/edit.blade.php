<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-900 leading-tight">
                {{ __('Edit Laporan Pengaduan') }}
            </h2>

            <a href="{{ route('warga.complaints.index') }}"
               class="text-sm font-bold text-blue-600 hover:text-blue-800 transition">
                &larr; Kembali ke Daftar
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">

            <div class="bg-black/35 backdrop-blur-xl overflow-hidden shadow-2xl sm:rounded-3xl border border-white/20 text-white">

                <!-- Header Form -->
                <div class="p-8 border-b border-white/10 bg-white/10">
                    <div class="flex items-center gap-4">
                        <div class="w-12 h-12 rounded-2xl bg-blue-400/20 border border-blue-300/30 flex items-center justify-center shrink-0">
                            <svg class="w-6 h-6 text-blue-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round"
                                      stroke-linejoin="round"
                                      stroke-width="2"
                                      d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5M18.5 2.5a2.121 2.121 0 013 3L12 15l-4 1 1-4 9.5-9.5z">
                                </path>
                            </svg>
                        </div>

                        <div>
                            <h3 class="text-2xl font-black text-white">
                                Edit Laporan
                            </h3>

                            <p class="text-sm text-white/65 mt-1">
                                Perbarui data laporan pengaduan Anda dengan benar.
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Form -->
                <form action="{{ route('warga.complaints.update', $complaint) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div class="p-8 space-y-7">

                        <!-- Judul -->
                        <div>
                            <label class="block text-sm font-bold text-white/90 mb-2">
                                Judul Laporan
                            </label>

                            <input type="text"
                                   name="title"
                                   value="{{ old('title', $complaint->title) }}"
                                   class="block w-full rounded-2xl border border-white/20 bg-white/10 text-white placeholder-white/45 shadow-sm focus:border-blue-400 focus:ring-blue-400"
                                   placeholder="Contoh: Jalan Berlubang di RT 01"
                                   required>

                            @error('title')
                                <p class="mt-2 text-xs text-rose-300 font-semibold">
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>

                        <!-- Deskripsi -->
                        <div>
                            <label class="block text-sm font-bold text-white/90 mb-2">
                                Isi Laporan / Deskripsi
                            </label>

                            <textarea name="description"
                                      rows="5"
                                      class="block w-full rounded-2xl border border-white/20 bg-white/10 text-white placeholder-white/45 shadow-sm focus:border-blue-400 focus:ring-blue-400"
                                      placeholder="Jelaskan detail masalah..."
                                      required>{{ old('description', $complaint->description) }}</textarea>

                            @error('description')
                                <p class="mt-2 text-xs text-rose-300 font-semibold">
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>

                        <!-- Foto Bukti -->
                        <div>
                            <label class="block text-sm font-bold text-white/90 mb-3">
                                Foto Bukti
                            </label>

                            <div class="rounded-3xl border border-white/20 bg-white/10 p-5">

                                @if($complaint->photo_path)
                                    <div class="mb-5">
                                        <p class="text-xs font-bold text-white/60 mb-3">
                                            Foto saat ini:
                                        </p>

                                        <a href="{{ asset('storage/' . $complaint->photo_path) }}" target="_blank">
                                            <img src="{{ asset('storage/' . $complaint->photo_path) }}"
                                                 class="w-40 h-40 object-cover rounded-2xl border-4 border-white/60 shadow-lg hover:scale-[1.02] transition duration-300">
                                        </a>

                                        <p class="text-[10px] text-white/45 mt-2 italic">
                                            Klik gambar untuk memperbesar
                                        </p>
                                    </div>
                                @endif

                                <input type="file"
                                       name="photo"
                                       class="block w-full text-sm text-white/70
                                              file:mr-4 file:py-2 file:px-5
                                              file:rounded-full file:border-0
                                              file:text-sm file:font-bold
                                              file:bg-[#0077B6] file:text-white
                                              hover:file:bg-[#006494]">

                                <p class="mt-3 text-xs text-white/45 italic">
                                    Kosongkan jika tidak ingin mengganti foto.
                                </p>
                            </div>

                            @error('photo')
                                <p class="mt-2 text-xs text-rose-300 font-semibold">
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>

                        <!-- Lokasi -->
                        <div>
                            <div class="flex justify-between items-center mb-3">
                                <label class="block text-sm font-bold text-white/90">
                                    Lokasi Laporan
                                </label>

                                <button type="button"
                                        onclick="getLocation()"
                                        class="text-xs text-blue-300 font-bold hover:text-blue-200 hover:underline transition">
                                    Perbarui Lokasi Saya Otomatis
                                </button>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-xs font-black uppercase tracking-widest text-white/45 mb-2">
                                        Latitude
                                    </label>

                                    <input type="text"
                                           name="latitude"
                                           id="lat"
                                           value="{{ old('latitude', $complaint->latitude) }}"
                                           class="block w-full rounded-2xl border border-white/20 bg-white/10 text-white placeholder-white/45 shadow-sm focus:border-blue-400 focus:ring-blue-400"
                                           placeholder="Belum diambil"
                                           readonly
                                           required>

                                    @error('latitude')
                                        <p class="mt-2 text-xs text-rose-300 font-semibold">
                                            {{ $message }}
                                        </p>
                                    @enderror
                                </div>

                                <div>
                                    <label class="block text-xs font-black uppercase tracking-widest text-white/45 mb-2">
                                        Longitude
                                    </label>

                                    <input type="text"
                                           name="longitude"
                                           id="lng"
                                           value="{{ old('longitude', $complaint->longitude) }}"
                                           class="block w-full rounded-2xl border border-white/20 bg-white/10 text-white placeholder-white/45 shadow-sm focus:border-blue-400 focus:ring-blue-400"
                                           placeholder="Belum diambil"
                                           readonly
                                           required>

                                    @error('longitude')
                                        <p class="mt-2 text-xs text-rose-300 font-semibold">
                                            {{ $message }}
                                        </p>
                                    @enderror
                                </div>
                            </div>

                            <div class="mt-4 p-4 bg-blue-400/10 rounded-2xl border border-blue-300/20 flex items-start gap-3">
                                <svg class="w-5 h-5 text-blue-200 mt-0.5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round"
                                          stroke-linejoin="round"
                                          stroke-width="2"
                                          d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z">
                                    </path>
                                </svg>

                                <p class="text-xs text-blue-100 leading-normal">
                                    Tekan tombol perbarui lokasi jika lokasi laporan berubah.
                                    Pastikan izin lokasi browser aktif.
                                </p>
                            </div>
                        </div>

                    </div>

                    <!-- Footer Aksi -->
                    <div class="px-8 py-6 bg-white/10 border-t border-white/10 flex justify-end gap-3">
                        <a href="{{ route('warga.complaints.index') }}"
                           class="px-6 py-2 bg-white/15 border border-white/20 text-white font-bold text-xs rounded-xl hover:bg-white/25 transition shadow-sm">
                            Batal
                        </a>

                        <button type="submit"
                                class="px-8 py-2 bg-[#0077B6] text-white font-bold text-xs rounded-xl hover:bg-[#006494] transition shadow-lg shadow-blue-900/20">
                            Simpan Perubahan
                        </button>
                    </div>
                </form>

            </div>
        </div>
    </div>

    <!-- Script Ambil Lokasi -->
    <script>
        function getLocation() {
            if (navigator.geolocation) {
                navigator.geolocation.getCurrentPosition(
                    function(position) {
                        document.getElementById('lat').value = position.coords.latitude;
                        document.getElementById('lng').value = position.coords.longitude;
                    },
                    function(error) {
                        alert("Gagal mengambil lokasi. Pastikan izin GPS aktif.");
                    }
                );
            } else {
                alert("Browser Anda tidak mendukung deteksi lokasi.");
            }
        }
    </script>
</x-app-layout>