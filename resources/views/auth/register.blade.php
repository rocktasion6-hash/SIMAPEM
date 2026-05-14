<x-guest-layout>
    <div class="mb-8 text-center">
        <!-- Judul Aplikasi -->
        <h1 class="text-4xl font-black text-indigo-600 tracking-tighter">
            SIMAPEM
        </h1>
        <p class="text-gray-500 text-sm mt-1">Buat akun untuk mulai melapor</p>
    </div>

    <form method="POST" action="{{ route('register') }}" class="bg-white p-2">
        @csrf

        <!-- Name -->
        <div>
            <x-input-label for="name" :value="__('Nama Lengkap')" class="font-semibold" />
            <x-text-input id="name" class="block mt-1 w-full bg-gray-50 border-gray-200 focus:border-indigo-500 focus:ring-indigo-500 rounded-lg" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" placeholder="Nama sesuai KTP" />
            <x-input-error :messages="$errors->get('name')" class="mt-2" />
        </div>

        <!-- Email Address -->
        <div class="mt-4">
            <x-input-label for="email" :value="__('Email')" class="font-semibold" />
            <x-text-input id="email" class="block mt-1 w-full bg-gray-50 border-gray-200 focus:border-indigo-500 focus:ring-indigo-500 rounded-lg" type="email" name="email" :value="old('email')" required autocomplete="username" placeholder="contoh@email.com" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mt-4">
            <x-input-label for="password" :value="__('Password')" class="font-semibold" />
            <x-text-input id="password" class="block mt-1 w-full bg-gray-50 border-gray-200 focus:border-indigo-500 focus:ring-indigo-500 rounded-lg"
                            type="password"
                            name="password"
                            required autocomplete="new-password" 
                            placeholder="Minimal 8 karakter" />
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Confirm Password -->
        <div class="mt-4">
            <x-input-label for="password_confirmation" :value="__('Konfirmasi Password')" class="font-semibold" />
            <x-text-input id="password_confirmation" class="block mt-1 w-full bg-gray-50 border-gray-200 focus:border-indigo-500 focus:ring-indigo-500 rounded-lg"
                            type="password"
                            name="password_confirmation" required autocomplete="new-password" 
                            placeholder="Ulangi password" />
            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        <div class="mt-6">
            <x-primary-button class="w-full justify-center py-3 bg-indigo-600 hover:bg-indigo-700 transition duration-150 ease-in-out shadow-lg shadow-indigo-200">
                {{ __('Daftar Akun Baru') }}
            </x-primary-button>
        </div>

        <!-- Tombol Kembali ke Login -->
        <div class="mt-8 text-center border-t pt-6">
            <p class="text-sm text-gray-600">
                Sudah punya akun? 
                <a href="{{ route('login') }}" class="font-bold text-indigo-600 hover:text-indigo-800 underline underline-offset-4">
                    Masuk Sekarang
                </a>
            </p>
        </div>
    </form>
</x-guest-layout>