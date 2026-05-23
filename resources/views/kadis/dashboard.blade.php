<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard Monitoring Kepala Dinas') }}
        </h2>
    </x-slot>

    <div class="py-12 bg-gray-50 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <!-- STATS CARDS -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">

                <!-- Card: Total Laporan -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg border-l-4 border-blue-500">
                    <div class="p-6 text-gray-900">
                        <div class="text-sm font-medium text-gray-500 uppercase tracking-wider">
                            Total Laporan
                        </div>
                        <div class="flex items-center mt-1">
                            <div class="text-3xl font-bold text-gray-800">
                                {{ $stats['total'] }}
                            </div>
                            <span class="ml-2 text-xs text-gray-400">
                                Aduan Masuk
                            </span>
                        </div>
                    </div>
                </div>

                <!-- Card: Menunggu Verifikasi -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg border-l-4 border-red-500">
                    <div class="p-6 text-gray-900">
                        <div class="text-sm font-medium text-gray-500 uppercase tracking-wider">
                            Menunggu
                        </div>
                        <div class="flex items-center mt-1">
                            <div class="text-3xl font-bold text-gray-800">
                                {{ $stats['pending'] }}
                            </div>
                            <span class="ml-2 text-xs text-gray-400">
                                Perlu Dicek
                            </span>
                        </div>
                    </div>
                </div>

                <!-- Card: Dalam Proses -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg border-l-4 border-yellow-500">
                    <div class="p-6 text-gray-900">
                        <div class="text-sm font-medium text-gray-500 uppercase tracking-wider">
                            Dalam Proses
                        </div>
                        <div class="flex items-center mt-1">
                            <div class="text-3xl font-bold text-gray-800">
                                {{ $stats['process'] }}
                            </div>
                            <span class="ml-2 text-xs text-gray-400">
                                Sedang Dikerjakan
                            </span>
                        </div>
                    </div>
                </div>

                <!-- Card: Selesai -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg border-l-4 border-green-500">
                    <div class="p-6 text-gray-900">
                        <div class="text-sm font-medium text-gray-500 uppercase tracking-wider">
                            Selesai
                        </div>
                        <div class="flex items-center mt-1">
                            <div class="text-3xl font-bold text-gray-800">
                                {{ $stats['resolved'] }}
                            </div>
                            <span class="ml-2 text-xs text-gray-400">
                                Tuntas
                            </span>
                        </div>
                    </div>
                </div>

            </div>


            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

                <!-- Tabel Kategori Terbanyak -->
                <div class="lg:col-span-2 bg-white p-6 rounded-xl shadow-sm">
                    <h3 class="font-bold text-gray-700 mb-4 flex items-center gap-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                        </svg>
                        Laporan Berdasarkan Kategori
                    </h3>

                    <div class="overflow-x-auto">
                        <table class="w-full text-sm text-left">
                            <thead class="bg-gray-50 text-gray-600">
                                <tr>
                                    <th class="px-4 py-3 rounded-l-lg">Nama Kategori</th>
                                    <th class="px-4 py-3 text-center rounded-r-lg">Jumlah Laporan</th>
                                </tr>
                            </thead>

                            <tbody class="divide-y">
                                @forelse($categoryStats as $stat)
                                    <tr>
                                        <td class="px-4 py-4 font-medium text-gray-800">
                                            {{ $stat->name }}
                                        </td>
                                        <td class="px-4 py-4 text-center">
                                            <span class="bg-indigo-100 text-indigo-700 px-3 py-1 rounded-full font-bold">
                                                {{ $stat->total }}
                                            </span>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="2" class="px-4 py-8 text-center text-gray-400">
                                            Belum ada data kategori laporan.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Informasi Tambahan -->
                <div class="bg-indigo-900 p-6 rounded-xl shadow-sm text-white">
                    <h3 class="font-bold mb-4">
                        Informasi Sistem
                    </h3>

                    <div class="space-y-4 text-sm opacity-90">
                        <p>
                            Dashboard ini digunakan oleh Kepala Dinas untuk memantau perkembangan laporan masyarakat
                            berdasarkan data yang masuk ke dalam sistem.
                        </p>

                        <hr class="opacity-20">

                        <div>
                            <p class="font-bold text-indigo-300">
                                Monitoring Laporan:
                            </p>
                            <p>
                                Kepala Dinas dapat melihat jumlah laporan masuk, laporan yang masih menunggu,
                                laporan yang sedang diproses, dan laporan yang sudah selesai.
                            </p>
                        </div>

                        <div class="bg-indigo-800 p-4 rounded-lg">
                            <p class="text-xs italic text-indigo-200">
                                "Transparansi dan kecepatan adalah kunci pelayanan publik yang prima."
                            </p>
                        </div>

                        <a href="{{ route('kadis.complaints.index') }}"
                           class="block mt-4 text-center bg-sky-500 hover:bg-sky-600 text-white font-bold py-2 rounded-lg transition">
                            Lihat Semua Laporan
                        </a>
                    </div>
                </div>

            </div>

        </div>
    </div>
</x-app-layout>