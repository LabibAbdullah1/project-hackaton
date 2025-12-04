<nav class="fixed w-full bg-white/80 backdrop-blur-md z-50 shadow-sm">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between items-center h-16">
            <!-- Logo -->
            <div class="flex items-center">
                <svg class="w-6 h-6 sm:w-8 sm:h-8 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                </svg>
                <span
                    class="ml-2 text-lg sm:text-2xl font-bold bg-gradient-to-r from-purple-600 to-pink-600 bg-clip-text text-transparent">
                    VibeSense AI
                </span>
            </div>

            <!-- Navigation Links - Hidden on Mobile -->
            <div class="hidden lg:flex items-center space-x-8">
                <a href="#index" class="text-gray-700 hover:text-purple-600 transition-colors font-medium">Home</a>
                <a href="#features" class="text-gray-700 hover:text-purple-600 transition-colors font-medium">Fitur</a>
                <a href="#testimonials"
                    class="text-gray-700 hover:text-purple-600 transition-colors font-medium">Testimoni</a>
            </div>

            <!-- CTA Buttons -->
            <div class="flex items-center space-x-2 sm:space-x-4">
                @auth
                    <a href="{{ route('dashboard') }}"
                        class="hidden sm:inline-block text-purple-600 hover:text-purple-700 font-semibold transition-colors text-sm lg:text-base">
                        Dashboard
                    </a>
                    <form action="{{ route('logout') }}" method="POST" class="inline-block">
                        @csrf
                        <button type="submit"
                            class="bg-gradient-to-r from-purple-600 to-pink-600 text-white px-4 sm:px-6 py-2 rounded-full text-sm sm:text-base font-semibold hover:shadow-lg transform hover:-translate-y-0.5 transition-all duration-200">
                            Logout
                        </button>
                    </form>
                @else
                    <a href="{{ route('login') }}"
                        class="hidden sm:inline-block text-purple-600 hover:text-purple-700 font-semibold transition-colors text-sm lg:text-base">
                        Masuk
                    </a>
                    <a href="{{ route('register') }}"
                        class="bg-gradient-to-r from-purple-600 to-pink-600 text-white px-4 sm:px-6 py-2 rounded-full text-sm sm:text-base font-semibold hover:shadow-lg transform hover:-translate-y-0.5 transition-all duration-200">
                        Daftar
                    </a>
                @endauth
            </div>
        </div>
    </div>
</nav>
