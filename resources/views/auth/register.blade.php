<x-guest-layout>

    <div>

        <!-- Card -->
        <div
            class="w-full max-w-md bg-white/20 backdrop-blur-xl border border-white/30 
            shadow-xl rounded-3xl p-8">

            <!-- Title -->
            <h2 class="text-3xl font-bold text-white text-center mb-2">
                Buat Akun Baru
            </h2>
            <p class="text-white/80 text-center mb-6 text-sm">
                Mulai perjalanan diary & emotional wellness kamu ✨
            </p>

            <form method="POST" action="{{ route('register') }}">
                @csrf

                <!-- Name -->
                <div class="mb-4">
                    <x-input-label for="name" class="text-white" :value="__('Nama Lengkap')" />
                    <x-text-input id="name" type="text" name="name" :value="old('name')" required autofocus
                        autocomplete="name" class="mt-1 w-full rounded-xl focus:ring-purple-400" />
                    <x-input-error :messages="$errors->get('name')" class="mt-2 text-white" />
                </div>

                <!-- Email -->
                <div class="mb-4">
                    <x-input-label for="email" class="text-white" :value="__('Email')" />
                    <x-text-input id="email" type="email" name="email" :value="old('email')" required
                        autocomplete="username" class="mt-1 w-full rounded-xl focus:ring-purple-400" />
                    <x-input-error :messages="$errors->get('email')" class="mt-2 text-white" />
                </div>

                <!-- Password -->
                <div class="mb-4">
                    <x-input-label for="password" class="text-white" :value="__('Password')" />
                    <x-text-input id="password" type="password" name="password" required autocomplete="new-password"
                        class="mt-1 w-full rounded-xl focus:ring-purple-400" />
                    <x-input-error :messages="$errors->get('password')" class="mt-2 text-white" />
                </div>

                <!-- Password Confirm -->
                <div class="mb-4">
                    <x-input-label for="password_confirmation" class="text-white" :value="__('Konfirmasi Password')" />
                    <x-text-input id="password_confirmation" type="password" name="password_confirmation" required
                        autocomplete="new-password" class="mt-1 w-full rounded-xl focus:ring-purple-400" />
                    <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2 text-white" />
                </div>

                <!-- Button -->
                <div class="flex items-center justify-end mt-4">

                    <x-primary-button
                        class="bg-stone-800 text-white-600  rounded-full px-5 py-2 font-semibold transition-all">
                        Daftar
                    </x-primary-button>
                </div>

                <!-- Login Link -->
                <p class="text-white/90 text-center mt-6 text-sm">
                    Sudah punya akun?
                    <a href="{{ route('login') }}" class="font-semibold underline hover:text-white">
                        Masuk sekarang
                    </a>
                </p>

            </form>

        </div>
    </div>

</x-guest-layout>
