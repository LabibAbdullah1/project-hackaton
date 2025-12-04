<x-guest-layout>

    <div>

        <!-- Card -->
        <div
            class="w-full max-w-md bg-white/20 backdrop-blur-xl border border-white/30 
            shadow-xl rounded-3xl p-8">

            <!-- Title -->
            <h2 class="text-3xl font-bold text-white text-center mb-2">
                Welcome
            </h2>
            <p class="text-white/80 text-center mb-6 text-sm">
                Masuk untuk melanjutkan perjalanan mindful kamu ✨
            </p>

            <!-- Session Status -->
            <x-auth-session-status class="mb-4 text-white" :status="session('status')" />

            <!-- Form -->
            <form method="POST" action="{{ route('login') }}">
                @csrf

                <!-- Email -->
                <div class="mb-4">
                    <x-input-label class="text-white" for="email" :value="__('Email')" />
                    <x-text-input id="email" type="email" name="email" :value="old('email')" required autofocus
                        autocomplete="username" class="mt-1 w-full rounded-xl focus:ring-purple-400" />
                    <x-input-error :messages="$errors->get('email')" class="mt-2 text-white" />
                </div>

                <!-- Password -->
                <div class="mb-4">
                    <x-input-label class="text-white" for="password" :value="__('Password')" />
                    <x-text-input id="password" type="password" name="password" required
                        autocomplete="current-password" class="mt-1 w-full rounded-xl focus:ring-purple-400" />
                    <x-input-error :messages="$errors->get('password')" class="mt-2 text-white" />
                </div>

                <!-- Remember Me -->
                <label for="remember_me" class="inline-flex items-center mb-4">
                    <input id="remember_me" type="checkbox"
                        class="rounded border-gray-300 text-purple-500 shadow-sm focus:ring-purple-400" name="remember">
                    <span class="ms-2 text-sm text-white/80">
                        Ingat saya
                    </span>
                </label>

                <!-- Bottom Row -->
                <div class="flex items-center justify-between mt-4">

                    @if (Route::has('password.request'))
                        <a href="{{ route('password.request') }}"
                            class="text-sm text-white/80 hover:text-white underline">
                            Lupa password?
                        </a>
                    @endif

                    <!-- Button -->
                    <x-primary-button
                        class="bg-stone-800 text-white-600  rounded-full px-5 py-2 font-semibold transition-all">
                        Masuk
                    </x-primary-button>
                </div>

                <!-- Register Link -->
                <p class="text-white/90 text-center mt-6 text-sm">
                    Belum punya akun?
                    <a href="{{ route('register') }}" class="font-semibold underline hover:text-white">
                        Daftar sekarang
                    </a>
                </p>

            </form>
        </div>
    </div>

</x-guest-layout>
