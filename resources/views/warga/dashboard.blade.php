<x-app-layout>
    <x-slot name="header">
        <div>
            <h2 class="font-bold text-2xl text-gray-800 leading-tight">
                Dashboard Warga
            </h2>
            <p class="text-sm text-gray-500 mt-1">
                Selamat datang di Sistem Pengaduan Masyarakat.
            </p>
        </div>
    </x-slot>

    <div class="py-10 bg-gray-50 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-8">

            <!-- Hero Section -->
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                <div class="p-8 md:p-10 flex flex-col md:flex-row items-center justify-between gap-8">
                    <div class="max-w-2xl">
                        <span class="inline-block px-4 py-1 bg-blue-50 text-blue-700 text-sm font-semibold rounded-full mb-4">
                            SIMAPEM PALU
                        </span>

                        <h1 class="text-3xl md:text-4xl font-extrabold text-gray-900 leading-tight">
                            Sampaikan Pengaduan Masyarakat dengan Mudah dan Cepat
                        </h1>

                        <p class="mt-4 text-gray-600 leading-relaxed">
                            SIMAPEM adalah sistem yang digunakan untuk membantu warga dalam menyampaikan laporan atau pengaduan kepada pemerintah secara online.
                            Melalui sistem ini, warga dapat membuat laporan, memantau status laporan, dan melihat perkembangan penanganan laporan.
                        </p>

                        <div class="mt-6 flex flex-col sm:flex-row gap-3">
                            <a href="{{ route('warga.complaints.create') }}"
                               class="inline-flex items-center justify-center px-6 py-3 bg-indigo-600 text-white font-semibold rounded-xl hover:bg-indigo-700 transition">
                                Buat Laporan
                            </a>

                            <a href="{{ route('warga.complaints.index') }}"
                               class="inline-flex items-center justify-center px-6 py-3 bg-white border border-gray-300 text-gray-700 font-semibold rounded-xl hover:bg-gray-100 transition">
                                Lihat Laporan Saya
                            </a>
                        </div>
                    </div>

                    <div class="w-full md:w-80 bg-white/10 backdrop-blur-md rounded-2xl p-6 border border-white/20 shadow-lg">
                        <h3 class="font-bold text-white mb-4">
                            Alur Pengaduan
                        </h3>

                        <div class="space-y-4">
                            <div class="flex gap-3">
                                <div class="w-8 h-8 rounded-full bg-indigo-600 text-white flex items-center justify-center font-bold text-sm">1</div>
                                <div>
                                    <p class="font-semibold text-gray-800">Buat Laporan</p>
                                    <p class="text-sm text-gray-500">Warga mengisi data pengaduan.</p>
                                </div>
                            </div>

                            <div class="flex gap-3">
                                <div class="w-8 h-8 rounded-full bg-indigo-600 text-white flex items-center justify-center font-bold text-sm">2</div>
                                <div>
                                    <p class="font-semibold text-gray-800">Diverifikasi</p>
                                    <p class="text-sm text-gray-500">Front Office memeriksa laporan.</p>
                                </div>
                            </div>

                            <div class="flex gap-3">
                                <div class="w-8 h-8 rounded-full bg-indigo-600 text-white flex items-center justify-center font-bold text-sm">3</div>
                                <div>
                                    <p class="font-semibold text-gray-800">Ditangani Petugas</p>
                                    <p class="text-sm text-gray-500">Laporan diteruskan ke pelaksana.</p>
                                </div>
                            </div>

                            <div class="flex gap-3">
                                <div class="w-8 h-8 rounded-full bg-indigo-600 text-white flex items-center justify-center font-bold text-sm">4</div>
                                <div>
                                    <p class="font-semibold text-gray-800">Selesai</p>
                                    <p class="text-sm text-gray-500">Warga dapat melihat hasil penanganan.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>


            <!-- Statistik Laporan Warga -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5">
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
                    <p class="text-sm text-gray-500">Total Laporan</p>
                    <h3 class="text-3xl font-extrabold text-gray-900 mt-2">{{ $stats['total'] }}</h3>
                </div>

                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
                    <p class="text-sm text-gray-500">Menunggu Verifikasi</p>
                    <h3 class="text-3xl font-extrabold text-yellow-600 mt-2">{{ $stats['pending'] }}</h3>
                </div>

                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
                    <p class="text-sm text-gray-500">Sedang Diproses</p>
                    <h3 class="text-3xl font-extrabold text-blue-600 mt-2">{{ $stats['process'] }}</h3>
                </div>

                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
                    <p class="text-sm text-gray-500">Selesai</p>
                    <h3 class="text-3xl font-extrabold text-green-600 mt-2">{{ $stats['resolved'] }}</h3>
                </div>
            </div>


            <!-- Info dan Laporan Terbaru -->
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

                <!-- Tentang SIMAPEM -->
                <div class="lg:col-span-1 bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
                    <h3 class="text-lg font-bold text-gray-800 mb-3">
                        Apa itu SIMAPEM?
                    </h3>

                    <p class="text-sm text-gray-600 leading-relaxed">
                        SIMAPEM adalah Sistem Pengaduan Masyarakat yang digunakan untuk mempermudah proses pelaporan masalah di lingkungan masyarakat.
                        Sistem ini membantu laporan warga agar lebih terdata, terarah, dan mudah dipantau.
                    </p>

                    <div class="mt-5 p-4 bg-gray-50 rounded-xl">
                        <p class="text-sm font-semibold text-gray-700">
                            Gunakan sistem ini untuk melaporkan masalah seperti:
                        </p>
                        <ul class="mt-2 text-sm text-gray-600 list-disc list-inside space-y-1">
                            <li>Jalan rusak</li>
                            <li>Sampah menumpuk</li>
                            <li>Lampu jalan mati</li>
                            <li>Drainase bermasalah</li>
                            <li>Fasilitas umum rusak</li>
                        </ul>
                    </div>
                </div>

                <!-- Laporan Terbaru -->
                <div class="lg:col-span-2 bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
                    <div class="flex items-center justify-between mb-5">
                        <h3 class="text-lg font-bold text-gray-800">
                            Laporan Terbaru Saya
                        </h3>

                        <a href="{{ route('warga.complaints.index') }}"
                           class="text-sm font-semibold text-indigo-600 hover:text-indigo-800">
                            Lihat Semua
                        </a>
                    </div>

                    @forelse ($recentComplaints as $complaint)
                        <div class="border border-white/20 bg-white/10 backdrop-blur-sm rounded-xl p-4 mb-3 hover:bg-white/20 transition">
                            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-2">
                                <div>
                                    <h4 class="font-bold text-gray-800">
                                        {{ $complaint->title }}
                                    </h4>

                                    <p class="text-sm text-gray-500 mt-1">
                                        Kode: {{ $complaint->tracking_code }}
                                    </p>

                                    <p class="text-sm text-gray-500">
                                        Kategori:
                                        {{ $complaint->category->name ?? 'Belum dikategorikan' }}
                                    </p>
                                </div>

                                <div class="text-left sm:text-right">
                                    <span class="inline-block px-3 py-1 rounded-full text-xs font-bold bg-gray-100 text-gray-700">
                                        {{ str_replace('_', ' ', ucfirst($complaint->status->value)) }}
                                    </span>

                                    <p class="text-xs text-gray-400 mt-2">
                                        {{ $complaint->created_at->format('d M Y') }}
                                    </p>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="text-center py-10 bg-gray-50 rounded-xl">
                            <p class="text-gray-500">
                                Kamu belum memiliki laporan.
                            </p>

                            <a href="{{ route('warga.complaints.create') }}"
                               class="inline-block mt-4 px-5 py-2 bg-indigo-600 text-white text-sm font-semibold rounded-lg hover:bg-indigo-700 transition">
                                Buat Laporan Pertama
                            </a>
                        </div>
                    @endforelse
                </div>

            </div>

        </div>
    </div>

    <!-- AI Chatbot Tracking Laporan -->
<div class="fixed bottom-6 right-6 z-50">
    <!-- Tombol Chat -->
    <button id="chat-toggle"
            class="w-14 h-14 rounded-full bg-sky-600 hover:bg-sky-700 text-white shadow-lg flex items-center justify-center font-bold">
        AI
    </button>

    <!-- Box Chat -->
    <div id="chat-box"
         class="hidden absolute bottom-20 right-0 w-80 bg-white rounded-2xl shadow-2xl border border-gray-200 overflow-hidden">

        <!-- Header Chat -->
        <div class="bg-sky-600 text-white px-4 py-3">
            <h3 class="font-bold">AI Tracking Laporan</h3>
            <p class="text-xs text-sky-100">
                Tanyakan status laporan Anda
            </p>
        </div>

        <!-- Isi Chat -->
        <div id="chat-messages" class="h-72 overflow-y-auto p-4 space-y-3 bg-gray-50">
            <div class="bg-white border border-gray-200 rounded-xl px-3 py-2 text-sm text-gray-700">
                Halo, saya AI SIMAPEM. Silakan tanya status laporan Anda.
                <br>
                Contoh: <b>Laporan saya sudah sampai mana?</b>
            </div>
        </div>

        <!-- Input Chat -->
        <div class="p-3 bg-white border-t border-gray-200">
            <div class="flex gap-2">
                <input id="chat-input"
                       type="text"
                       placeholder="Tulis pertanyaan..."
                       class="flex-1 rounded-xl border-gray-300 text-sm focus:border-sky-500 focus:ring-sky-500">

                <button id="chat-send"
                        type="button"
                        class="px-4 py-2 bg-sky-600 hover:bg-sky-700 text-white text-sm font-bold rounded-xl">
                    Kirim
                </button>
            </div>
        </div>
    </div>
</div>

<script>
    const chatToggle = document.getElementById('chat-toggle');
    const chatBox = document.getElementById('chat-box');
    const chatInput = document.getElementById('chat-input');
    const chatSend = document.getElementById('chat-send');
    const chatMessages = document.getElementById('chat-messages');

    chatToggle.addEventListener('click', function () {
        chatBox.classList.toggle('hidden');
    });

    function escapeHtml(text) {
        const div = document.createElement('div');
        div.innerText = text;
        return div.innerHTML;
    }

    async function sendChatMessage() {
        const message = chatInput.value.trim();

        if (!message) {
            return;
        }

        chatMessages.innerHTML += `
            <div class="flex justify-end">
                <div class="bg-sky-600 text-white rounded-xl px-3 py-2 text-sm max-w-[85%]">
                    ${escapeHtml(message)}
                </div>
            </div>
        `;

        chatInput.value = '';

        const loadingId = 'loading-' + Date.now();

        chatMessages.innerHTML += `
            <div id="${loadingId}" class="flex justify-start">
                <div class="bg-white border border-gray-200 text-gray-500 rounded-xl px-3 py-2 text-sm max-w-[85%]">
                    AI sedang memeriksa laporan...
                </div>
            </div>
        `;

        chatMessages.scrollTop = chatMessages.scrollHeight;

        try {
            const response = await fetch("{{ route('warga.ai.chat') }}", {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                    "X-CSRF-TOKEN": "{{ csrf_token() }}"
                },
                body: JSON.stringify({
                    message: message
                })
            });

            const data = await response.json();

            const loadingElement = document.getElementById(loadingId);
            if (loadingElement) {
                loadingElement.remove();
            }

            chatMessages.innerHTML += `
                <div class="flex justify-start">
                    <div class="bg-white border border-gray-200 text-gray-700 rounded-xl px-3 py-2 text-sm max-w-[85%]">
                        ${escapeHtml(data.reply ?? 'AI tidak memberikan jawaban.')}
                    </div>
                </div>
            `;

        } catch (error) {
            const loadingElement = document.getElementById(loadingId);
            if (loadingElement) {
                loadingElement.remove();
            }

            chatMessages.innerHTML += `
                <div class="flex justify-start">
                    <div class="bg-red-50 border border-red-200 text-red-700 rounded-xl px-3 py-2 text-sm max-w-[85%]">
                        Tidak bisa terhubung ke AI.
                    </div>
                </div>
            `;
        }

        chatMessages.scrollTop = chatMessages.scrollHeight;
    }

    chatSend.addEventListener('click', sendChatMessage);

    chatInput.addEventListener('keydown', function (e) {
        if (e.key === 'Enter') {
            sendChatMessage();
        }
    });
</script>
</x-app-layout>