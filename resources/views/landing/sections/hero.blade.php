<section id="index" class="pt-24 sm:pt-32 pb-12 sm:pb-20 px-4 sm:px-6 lg:px-8">
    <div class="max-w-7xl mx-auto">
        <div class="grid md:grid-cols-2 gap-8 sm:gap-12 items-center">
            <!-- Left Content -->
            <div class="space-y-6 sm:space-y-8 text-center md:text-left">
                <div class="inline-block">
                    <span
                        class="bg-purple-100 text-purple-600 px-3 sm:px-4 py-2 rounded-full text-xs sm:text-sm font-semibold">
                        ✨ Curhat Aman Dengan AI Empati
                    </span>
                </div>

                <h1 class="text-3xl sm:text-4xl md:text-5xl lg:text-6xl font-bold leading-tight">
                    Ceritakan <span
                        class="bg-gradient-to-r from-purple-600 to-pink-600 bg-clip-text text-transparent">Perasaanmu</span>,
                    <br />VibeSense AI Siap Mendengar
                </h1>

                <p class="text-base sm:text-lg md:text-xl text-gray-600 leading-relaxed">
                    VibeSense AI jadi diary digitalmu yang selalu siap mendengar. Tulis apa pun tentang harimu, biarkan
                    AI merangkum, menganalisis mood, dan memberikan refleksi supaya kamu makin kenal diri sendiri.
                </p>

                <div class="flex flex-col sm:flex-row gap-3 sm:gap-4">
                    @auth
                        <a href="{{ route('dashboard') }}"
                            class="bg-gradient-to-r from-purple-600 to-pink-600 text-white px-6 sm:px-8 py-3 sm:py-4 rounded-full font-semibold text-base sm:text-lg hover:shadow-xl transform hover:-translate-y-1 transition-all duration-200 text-center">
                            Buka Dashboard
                        </a>
                    @else
                        <a href="{{ route('register') }}"
                            class="bg-gradient-to-r from-purple-600 to-pink-600 text-white px-6 sm:px-8 py-3 sm:py-4 rounded-full font-semibold text-base sm:text-lg hover:shadow-xl transform hover:-translate-y-1 transition-all duration-200 text-center">
                            Mulai Menulis Sekarang
                        </a>
                    @endauth
                    <a href="{{ route('demo') }}"
                        class="border-2 border-purple-600 text-purple-600 px-6 sm:px-8 py-3 sm:py-4 rounded-full font-semibold text-base sm:text-lg hover:bg-purple-50 transition-all duration-200 text-center">
                        Lihat Demo
                    </a>
                </div>

                <div class="flex items-center justify-center md:justify-start space-x-4 sm:space-x-8 pt-4">
                    <div class="flex items-center">
                        <div class="flex -space-x-2">
                            <div
                                class="w-8 h-8 sm:w-10 sm:h-10 rounded-full bg-gradient-to-br from-purple-400 to-pink-400 border-2 border-white">
                            </div>
                            <div
                                class="w-8 h-8 sm:w-10 sm:h-10 rounded-full bg-gradient-to-br from-blue-400 to-purple-400 border-2 border-white">
                            </div>
                            <div
                                class="w-8 h-8 sm:w-10 sm:h-10 rounded-full bg-gradient-to-br from-pink-400 to-red-400 border-2 border-white">
                            </div>
                        </div>
                        <span class="ml-2 sm:ml-3 text-sm sm:text-base text-gray-600 font-medium">10k+ pengguna merasa
                            terbantu</span>
                    </div>
                </div>
            </div>

            <!-- Right Content - Illustration -->
            <div class="relative mt-8 md:mt-0">
                <div
                    class="relative z-10 bg-white rounded-2xl sm:rounded-3xl shadow-2xl p-6 sm:p-8 transform hover:rotate-0 transition-transform duration-300">
                    <div class="space-y-3 sm:space-y-4">
                        <div class="flex items-center space-x-3">
                            <div
                                class="w-10 h-10 sm:w-12 sm:h-12 rounded-full bg-gradient-to-br from-purple-400 to-pink-400">
                            </div>
                            <div class="flex-1">
                                <div class="h-2.5 sm:h-3 bg-gray-200 rounded w-20 sm:w-24 mb-2"></div>
                                <div class="h-2 bg-gray-100 rounded w-24 sm:w-32"></div>
                            </div>
                        </div>
                        <div class="space-y-2 pt-4">
                            <div class="h-2.5 sm:h-3 bg-gray-200 rounded"></div>
                            <div class="h-2.5 sm:h-3 bg-gray-200 rounded"></div>
                            <div class="h-2.5 sm:h-3 bg-gray-200 rounded w-4/5"></div>
                            <div class="h-12 sm:h-16 bg-gradient-to-r from-purple-100 to-pink-100 rounded-lg mt-4">
                            </div>
                        </div>
                    </div>
                </div>
                <div
                    class="absolute -bottom-4 sm:-bottom-6 -right-4 sm:-right-6 w-48 h-48 sm:w-72 sm:h-72 bg-gradient-to-br from-purple-200 to-pink-200 rounded-3xl -z-10">
                </div>
                <div
                    class="absolute -top-4 sm:-top-6 -left-4 sm:-left-6 w-32 h-32 sm:w-40 sm:h-40 bg-gradient-to-br from-blue-200 to-purple-200 rounded-full -z-10">
                </div>
            </div>
        </div>
    </div>
</section>
