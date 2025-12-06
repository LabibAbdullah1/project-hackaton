<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="icon" type="image/svg+xml" href="/favicon.svg">

    <title>{{ config('app.name', 'VibeSense AI') }} - @yield('title', 'Dashboard')</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-gray-50">

    <!-- Mobile Overlay -->
    <div id="sidebarOverlay" class="fixed inset-0 bg-black/50 z-40 lg:hidden hidden"></div>

    <!-- ============ SIDEBAR ============ -->
    <aside id="sidebar" 
        class="fixed left-0 top-0 h-screen bg-gradient-to-b from-purple-900 via-purple-800 to-indigo-900 text-white z-50 
               w-64 transform -translate-x-full lg:translate-x-0 transition-transform duration-300 ease-in-out
               shadow-2xl">
        
        <!-- Sidebar Content -->
        <div class="h-full overflow-y-auto">
            @include('layouts.partials.sidebar-content')
        </div>

        <!-- Close Button (Mobile Only) -->
        <button id="closeSidebar" 
            class="lg:hidden absolute top-4 right-4 text-white/70 hover:text-white p-2 z-10">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
            </svg>
        </button>
    </aside>

    <!-- ============ MAIN CONTENT ============ -->
    <div class="lg:ml-64 min-h-screen flex flex-col">

        {{-- TOPBAR --}}
        <header class="bg-white/80 backdrop-blur-md border-b border-gray-200 shadow-sm sticky top-0 z-30">
            <div class="px-4 sm:px-6 lg:px-8 py-3 sm:py-4">
                <div class="flex items-center justify-between gap-4">
                    
                    <!-- Mobile Menu Button & Page Title -->
                    <div class="flex items-center gap-3 min-w-0 flex-1">
                        <!-- Hamburger Menu (Mobile Only) -->
                        <button id="openSidebar" 
                            class="lg:hidden text-gray-600 hover:text-purple-600 p-2 -ml-2 rounded-lg hover:bg-purple-50 transition-all">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                            </svg>
                        </button>

                        <!-- Page Title with Icon -->
                        <div class="flex items-center gap-2 sm:gap-3">
                            <div class="hidden sm:flex w-10 h-10 bg-gradient-to-br from-purple-500 to-pink-500 rounded-xl items-center justify-center shadow-lg shadow-purple-500/30">
                                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0h6" />
                                </svg>
                            </div>
                            <h2 class="text-lg sm:text-xl lg:text-2xl font-bold bg-gradient-to-r from-purple-600 to-pink-600 bg-clip-text text-transparent tracking-tight truncate">
                                @yield('title', 'Dashboard')
                            </h2>
                        </div>
                    </div>

                    <!-- Right Section: Search, Notifications, User Profile -->
                    <div class="flex items-center gap-2 sm:gap-4 flex-shrink-0">
                        
                        <!-- Quick Write Button (Hidden on Mobile) -->
                        <a href="{{ route('user.diary.create') }}" 
                           class="hidden md:flex items-center gap-2 bg-gradient-to-r from-purple-600 to-pink-600 text-white px-4 py-2 rounded-full text-sm font-semibold hover:from-purple-700 hover:to-pink-700 transition-all shadow-md hover:shadow-lg">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                            </svg>
                            <span>Write Diary</span>
                        </a>

                        {{-- <!-- Notification Bell -->
                        <button class="hidden sm:block relative p-2 text-gray-600 hover:text-purple-600 hover:bg-purple-50 rounded-lg transition-all">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path>
                            </svg>
                            <!-- Notification Badge -->
                            <span class="absolute top-1 right-1 w-2 h-2 bg-red-500 rounded-full"></span>
                        </button> --}}

                        <!-- User Dropdown -->
                        <div class="relative group">
                            <button class="flex items-center gap-2 sm:gap-3 p-1 rounded-full hover:bg-gray-100 transition-all">
                                <!-- User Info (Hidden on Small Mobile) -->
                                <div class="hidden sm:block text-right leading-tight">
                                    <p class="text-gray-800 font-semibold text-sm lg:text-base truncate max-w-[120px] lg:max-w-[150px]">
                                        {{ Auth::user()->name }}
                                    </p>
                                    <p class="text-gray-500 text-xs truncate max-w-[120px] lg:max-w-[150px]">
                                        {{ Auth::user()->email }}
                                    </p>
                                </div>

                                <!-- Avatar with Online Status -->
                                <div class="relative">
                                    <img src="https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->name) }}&background=7c3aed&color=fff"
                                        class="w-9 h-9 sm:w-10 sm:h-10 lg:w-11 lg:h-11 rounded-full border-2 border-purple-500 shadow-md flex-shrink-0" 
                                        alt="User Avatar">
                                    <span class="absolute bottom-0 right-0 w-3 h-3 bg-green-500 border-2 border-white rounded-full"></span>
                                </div>

                                <!-- Dropdown Arrow (Hidden on Mobile) -->
                                <svg class="hidden sm:block w-4 h-4 text-gray-500 group-hover:text-purple-600 transition-all" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                </svg>
                            </button>

                            <!-- Dropdown Menu (Hidden by default) -->
                            <div class="absolute right-0 mt-2 w-56 bg-white rounded-xl shadow-xl border border-gray-200 opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-200 z-50">
                                <div class="p-3 border-b border-gray-100">
                                    <p class="text-sm font-semibold text-gray-800">{{ Auth::user()->name }}</p>
                                    <p class="text-xs text-gray-500">{{ Auth::user()->email }}</p>
                                </div>
                                <div class="py-2">
                                    <a href="" class="flex items-center gap-3 px-4 py-2 text-sm text-gray-700 hover:bg-purple-50 hover:text-purple-600 transition-all">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                        </svg>
                                        Settings
                                    </a>
                                    <a href="{{ route('user.diary.index') }}" class="flex items-center gap-3 px-4 py-2 text-sm text-gray-700 hover:bg-purple-50 hover:text-purple-600 transition-all">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                                        </svg>
                                        My Diaries
                                    </a>
                                </div>
                                <div class="border-t border-gray-100 py-2">
                                    <form method="POST" action="{{ route('logout') }}">
                                        @csrf
                                        <button type="submit" class="flex items-center gap-3 px-4 py-2 text-sm text-red-600 hover:bg-red-50 transition-all w-full text-left">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
                                            </svg>
                                            Logout
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>

                    </div>

                </div>
            </div>
        </header>

        {{-- PAGE CONTENT --}}
        <main class="flex-1 p-4 sm:p-6 lg:p-8">
            @yield('content')
        </main>

        {{-- FOOTER (Optional) --}}
        <footer class="bg-white border-t border-gray-200 py-4 px-4 sm:px-6 lg:px-8 mt-auto">
            <div class="text-center text-gray-500 text-xs sm:text-sm">
                © {{ date('Y') }} VibeSense AI. Made with 💜 
            </div>
        </footer>
    </div>

    {{-- SCRIPTS SECTION --}}
    @yield('scripts')

    {{-- Sidebar Toggle Script --}}
    <script>
        // Sidebar Toggle for Mobile
        const sidebar = document.getElementById('sidebar');
        const overlay = document.getElementById('sidebarOverlay');
        const openBtn = document.getElementById('openSidebar');
        const closeBtn = document.getElementById('closeSidebar');

        function openSidebar() {
            sidebar.classList.remove('-translate-x-full');
            overlay.classList.remove('hidden');
            document.body.style.overflow = 'hidden';
        }

        function closeSidebar() {
            sidebar.classList.add('-translate-x-full');
            overlay.classList.add('hidden');
            document.body.style.overflow = '';
        }

        openBtn?.addEventListener('click', openSidebar);
        closeBtn?.addEventListener('click', closeSidebar);
        overlay?.addEventListener('click', closeSidebar);

        // Close sidebar on window resize to desktop
        window.addEventListener('resize', () => {
            if (window.innerWidth >= 1024) {
                closeSidebar();
            }
        });
    </script>

</body>

</html>