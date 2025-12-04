<section class="py-12 sm:py-16 md:py-20 px-4 sm:px-6 lg:px-8">
    <div class="max-w-7xl mx-auto">
        <div
            class="bg-gradient-to-r from-purple-600 via-pink-600 to-red-500 rounded-2xl sm:rounded-3xl shadow-2xl overflow-hidden">
            <div class="grid md:grid-cols-2 items-center">
                <!-- Left Content -->
                <div class="p-8 sm:p-10 md:p-12 lg:p-16">
                    <h2 class="text-3xl sm:text-4xl md:text-5xl font-bold text-white mb-4 sm:mb-6">
                        Siap Memulai Perjalanan Journaling-mu?
                    </h2>
                    <p class="text-base sm:text-lg md:text-xl text-purple-100 mb-6 sm:mb-8">
                        Curhat ke AI & Dapatkan Analisis Emosi Instan!

                    </p>

                    <div class="flex flex-col sm:flex-row gap-3 sm:gap-4">
                        @auth
                            <a href="{{ route('dashboard') }}"
                                class="bg-white text-purple-600 px-6 sm:px-8 py-3 sm:py-4 rounded-full font-semibold text-base sm:text-lg hover:bg-gray-50 transform hover:-translate-y-1 transition-all duration-200 text-center shadow-lg">
                                Buka Dashboard
                            </a>
                        @else
                            <a href="{{ route('register') }}"
                                class="bg-white text-purple-600 px-6 sm:px-8 py-3 sm:py-4 rounded-full font-semibold text-base sm:text-lg hover:bg-gray-50 transform hover:-translate-y-1 transition-all duration-200 text-center shadow-lg">
                                Daftar Sekarang
                            </a>
                        @endauth
                        <a href="#features"
                            class="border-2 border-white text-white px-6 sm:px-8 py-3 sm:py-4 rounded-full font-semibold text-base sm:text-lg hover:bg-white/10 transition-all duration-200 text-center">
                            Pelajari Lebih Lanjut
                        </a>
                    </div>

                    <div
                        class="mt-6 sm:mt-8 flex flex-col sm:flex-row items-start sm:items-center gap-3 sm:gap-6 text-white/90 text-sm sm:text-base">
                        <div class="flex items-center">
                            <svg class="w-5 h-5 mr-2 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd"
                                    d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                    clip-rule="evenodd" />
                            </svg>
                            <span>Gratis Forever</span>
                        </div>
                        <div class="flex items-center">
                            <svg class="w-5 h-5 mr-2 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd"
                                    d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                    clip-rule="evenodd" />
                            </svg>
                            <span>Tanpa Kartu Kredit</span>
                        </div>
                    </div>
                </div>

                <!-- Right Content - Decorative -->
                <div class="hidden md:block relative h-full min-h-[300px] lg:min-h-[400px]">
                    <div class="absolute inset-0 bg-white/10 backdrop-blur-sm"></div>
                    <div class="relative h-full flex items-center justify-center p-8 lg:p-12">
                        <!-- Decorative Circles -->
                        <div
                            class="absolute top-10 right-10 w-24 h-24 lg:w-32 lg:h-32 bg-white/20 rounded-full blur-2xl">
                        </div>
                        <div
                            class="absolute bottom-10 left-10 w-32 h-32 lg:w-40 lg:h-40 bg-pink-300/30 rounded-full blur-2xl">
                        </div>

                        <!-- Mock Diary Entry -->
                        <div
                            class="relative z-10 bg-white rounded-2xl shadow-2xl p-5 lg:p-6 max-w-sm w-full transform rotate-3 hover:rotate-0 transition-transform">
                            <div class="flex items-center space-x-3 mb-4">
                                <div
                                    class="w-10 h-10 rounded-full bg-gradient-to-br from-purple-400 to-pink-400 flex-shrink-0">
                                </div>
                                <div>
                                    <div class="font-semibold text-gray-800 text-sm lg:text-base">Curhat Hari Ini</div>
                                    <div class="text-xs lg:text-sm text-gray-500">4 Desember 2025</div>
                                </div>
                            </div>
                            <div class="space-y-2">
                                <div class="h-2 bg-gray-200 rounded w-full"></div>
                                <div class="h-2 bg-gray-200 rounded w-5/6"></div>
                                <div class="h-2 bg-gray-200 rounded w-4/6"></div>
                            </div>
                            <div class="mt-4 flex flex-wrap gap-2">
                                <span
                                    class="px-2.5 lg:px-3 py-1 bg-purple-100 text-purple-600 rounded-full text-xs font-medium">😊
                                    Senang</span>
                                <span
                                    class="px-2.5 lg:px-3 py-1 bg-pink-100 text-pink-600 rounded-full text-xs font-medium">❤️
                                    Bersyukur</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
