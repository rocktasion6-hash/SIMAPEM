<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Semua Laporan Masuk') }}
            </h2>
            <a href="{{ route('kadis.dashboard') }}" class="text-sm text-sky-300 hover:underline">
                &larr; Kembali ke Dashboard
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <div class="overflow-x-auto">
                    <table class="w-full text-sm text-left text-slate-200">
                        <thead class="text-xs uppercase bg-white/10 text-slate-300">
                            <tr>
                                <th class="px-4 py-3">Kode</th>
                                <th class="px-4 py-3">Pelapor</th>
                                <th class="px-4 py-3">Judul</th>
                                <th class="px-4 py-3">Kategori</th>
                                <th class="px-4 py-3">Status</th>
                                <th class="px-4 py-3">Tanggal</th>
                                <th class="px-4 py-3 text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-white/10">
                            @forelse ($complaints as $item)
                                <tr class="hover:bg-white/10 transition">
                                    <td class="px-4 py-3 font-mono text-sky-300 text-xs">{{ $item->tracking_code }}</td>
                                    <td class="px-4 py-3">{{ $item->user->name }}</td>
                                    <td class="px-4 py-3">{{ $item->title }}</td>
                                    <td class="px-4 py-3">
                                        <span class="px-2 py-1 bg-white/10 rounded text-xs">
                                            {{ $item->category?->name ?? '-' }}
                                        </span>
                                    </td>
                                    <td class="px-4 py-3">
                                        <span class="px-2 py-1 rounded-full text-xs font-bold
                                            @if($item->status->value == 'pending') bg-amber-100 text-amber-700
                                            @elseif($item->status->value == 'resolved') bg-emerald-100 text-emerald-700
                                            @elseif($item->status->value == 'rejected') bg-rose-100 text-rose-700
                                            @else bg-blue-100 text-blue-700 @endif">
                                            {{ ucfirst($item->status->value) }}
                                        </span>
                                    </td>
                                    <td class="px-4 py-3 text-xs">{{ $item->created_at->format('d M Y') }}</td>
                                    <td class="px-4 py-3 text-center">
                                        <a href="{{ route('kadis.complaints.show', $item) }}"
                                           class="px-3 py-1.5 bg-sky-600 hover:bg-sky-700 text-white text-xs font-bold rounded-lg transition">
                                            Lihat Detail
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="px-4 py-10 text-center text-slate-300">Belum ada laporan.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <div class="mt-6">
                    {{ $complaints->links() }}
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
