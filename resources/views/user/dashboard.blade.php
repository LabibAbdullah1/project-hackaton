@extends('layouts.user')
@section('title', 'Dashboard')

@section('content')
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

        <!-- Welcome Section -->
        <div class="mb-8 sm:mb-10">
            <h2 class="text-2xl sm:text-3xl md:text-4xl font-extrabold text-gray-800">
                Welcome back, <span
                    class="bg-gradient-to-r from-purple-600 to-pink-600 bg-clip-text text-transparent">{{ Auth::user()->name }}!</span>
            </h2>
            <p class="text-sm sm:text-base text-gray-500 mt-2">
                Berikut ringkasan aktivitas dan mood kamu 📊
            </p>
        </div>

        <!-- Stats Cards -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 sm:gap-6 mb-8 sm:mb-10">
            <!-- Total Diaries -->
            <div
                class="bg-gradient-to-br from-purple-500 to-purple-700 p-6 rounded-2xl shadow-lg text-white transform hover:scale-105 transition-transform cursor-pointer">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-purple-100 text-xs sm:text-sm font-medium">Total Diaries</p>
                        <p class="text-3xl sm:text-4xl font-bold mt-2" id="totalDiaries">{{ $stats['total_diaries'] ?? 0 }}
                        </p>
                        <p class="text-purple-200 text-xs mt-2">📚 All time</p>
                    </div>
                    <div class="bg-white/20 p-3 rounded-xl">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253">
                            </path>
                        </svg>
                    </div>
                </div>
            </div>

            <!-- This Month -->
            <div
                class="bg-gradient-to-br from-pink-500 to-rose-700 p-6 rounded-2xl shadow-lg text-white transform hover:scale-105 transition-transform cursor-pointer">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-pink-100 text-xs sm:text-sm font-medium">Bulan Ini</p>
                        <p class="text-3xl sm:text-4xl font-bold mt-2" id="monthlyDiaries">
                            {{ $stats['monthly_diaries'] ?? 0 }}</p>
                        <p class="text-pink-200 text-xs mt-2">📅 {{ now()->format('F Y') }}</p>
                    </div>
                    <div class="bg-white/20 p-3 rounded-xl">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z">
                            </path>
                        </svg>
                    </div>
                </div>
            </div>

            <!-- Mood Score Average -->
            <div
                class="bg-gradient-to-br from-blue-500 to-indigo-700 p-6 rounded-2xl shadow-lg text-white transform hover:scale-105 transition-transform cursor-pointer">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-blue-100 text-xs sm:text-sm font-medium">Rata-rata Mood</p>
                        <p class="text-3xl sm:text-4xl font-bold mt-2" id="avgMood">{{ $stats['avg_mood'] ?? 0 }}<span
                                class="text-xl">/100</span></p>
                        <p class="text-blue-200 text-xs mt-2">😊 {{ $stats['mood_label'] ?? 'Netral' }}</p>
                    </div>
                    <div class="bg-white/20 p-3 rounded-xl">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M14.828 14.828a4 4 0 01-5.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z">
                            </path>
                        </svg>
                    </div>
                </div>
            </div>

            <!-- Streak Days -->
            <div
                class="bg-gradient-to-br from-green-500 to-emerald-700 p-6 rounded-2xl shadow-lg text-white transform hover:scale-105 transition-transform cursor-pointer">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-green-100 text-xs sm:text-sm font-medium">Streak Days</p>
                        <p class="text-3xl sm:text-4xl font-bold mt-2" id="streakDays">{{ $stats['streak_days'] ?? 0 }} 🔥
                        </p>
                        <p class="text-green-200 text-xs mt-2">⚡ Keep it up!</p>
                    </div>
                    <div class="bg-white/20 p-3 rounded-xl">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                        </svg>
                    </div>
                </div>
            </div>
        </div>



    </div>

    <!-- Recent Diaries & Quick Actions -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

        <!-- Recent Diaries -->
        <div class="lg:col-span-2 bg-white p-6 rounded-2xl border border-gray-200 shadow-sm">
            <div class="flex items-center justify-between mb-6">
                <h3 class="text-lg font-bold text-gray-800">📝 Diary Terbaru</h3>
                <a href="{{ route('user.diary.index') }}"
                    class="text-sm text-purple-600 hover:text-purple-700 font-semibold">
                    Lihat Semua →
                </a>
            </div>

            <div class="space-y-4">
                @forelse($recent_diaries as $diary)
                    <div
                        class="p-4 border border-gray-200 rounded-xl hover:border-purple-300 hover:shadow-md transition-all cursor-pointer">
                        <div class="flex items-start justify-between gap-3 mb-2">
                            <h4 class="font-semibold text-gray-800 line-clamp-1 flex-1">
                                {{ Str::limit($diary->content, 60) }}
                            </h4>
                            @if ($diary->analysis)
                                <span
                                    class="px-2 py-1 text-xs font-semibold rounded-full bg-purple-100 text-purple-700 flex-shrink-0">
                                    {{ $diary->analysis->mood }}
                                </span>
                            @endif
                        </div>
                        <p class="text-sm text-gray-600 line-clamp-2 mb-3">{{ $diary->content }}</p>
                        <div class="flex items-center justify-between">
                            <span class="text-xs text-gray-500">{{ $diary->created_at->diffForHumans() }}</span>
                            <a href="{{ route('user.diary.show', $diary->id) }}"
                                class="text-xs text-purple-600 hover:text-purple-700 font-semibold">
                                Baca →
                            </a>
                        </div>
                    </div>
                @empty
                    <div class="text-center py-8">
                        <p class="text-gray-500">Belum ada diary</p>
                    </div>
                @endforelse
            </div>
        </div>

        <!-- Quick Actions -->
        <div class="bg-gradient-to-br from-purple-50 to-pink-50 p-6 rounded-2xl border border-purple-200 shadow-sm">
            <h3 class="text-lg font-bold text-gray-800 mb-6">⚡ Quick Actions</h3>

            <div class="space-y-3">
                <a href="{{ route('user.diary.create') }}"
                    class="flex items-center gap-3 p-4 bg-white rounded-xl border border-purple-200 hover:border-purple-400 hover:shadow-md transition-all group">
                    <div class="bg-gradient-to-br from-purple-500 to-pink-500 p-3 rounded-lg text-white">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                        </svg>
                    </div>
                    <div class="flex-1">
                        <p class="font-semibold text-gray-800 group-hover:text-purple-600 transition-colors">Write Diary</p>
                        <p class="text-xs text-gray-500">Tulis catatan hari ini</p>
                    </div>
                </a>

                

                <a href="{{ route('user.diary.index') }}"
                    class="flex items-center gap-3 p-4 bg-white rounded-xl border border-purple-200 hover:border-purple-400 hover:shadow-md transition-all group">
                    <div class="bg-gradient-to-br from-green-500 to-emerald-500 p-3 rounded-lg text-white">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253">
                            </path>
                        </svg>
                    </div>
                    <div class="flex-1">
                        <p class="font-semibold text-gray-800 group-hover:text-purple-600 transition-colors">View All
                            Diaries</p>
                        <p class="text-xs text-gray-500">Browse semua diary</p>
                    </div>
                </a>
            </div>

            <!-- Motivational Quote -->
            <div class="mt-6 p-4 bg-white rounded-xl border border-purple-200">
                <p class="text-sm text-gray-600 italic mb-2">"{{ $quote ?? 'Keep writing and reflecting!' }}"</p>
                <p class="text-xs text-purple-600 font-semibold">💜 VibeSense AI</p>
            </div>
        </div>

    </div>

    </div>
@endsection

@section('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
    <script src="{{ asset('js/dashboard.js') }}"></script>
    <script>
        // Kirim data chart dari server ke JS eksternal
        document.addEventListener('DOMContentLoaded', function() {
            const chartData = @json($chart_data ?? []);
            renderDashboardCharts(chartData);
        });
    </script>
@endsection
