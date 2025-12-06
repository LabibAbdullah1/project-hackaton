<?php

namespace App\Http\Controllers;

use App\Models\Diary;
use App\Models\DiaryAnalysis;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $userId = Auth::id();

        // Statistics
        $stats = [
            'total_diaries' => Diary::where('user_id', $userId)->count(),
            'monthly_diaries' => Diary::where('user_id', $userId)
                ->whereMonth('created_at', now()->month)
                ->whereYear('created_at', now()->year)
                ->count(),
            'avg_mood' => round(DiaryAnalysis::whereHas('diary', function($q) use ($userId) {
                $q->where('user_id', $userId);
            })->avg('mood_score') ?? 0),
            'streak_days' => $this->calculateStreak($userId),
        ];

        // Mood label based on average
        $stats['mood_label'] = $this->getMoodLabel($stats['avg_mood']);

        // Recent diaries
        $recent_diaries = Diary::with('analysis')
            ->where('user_id', $userId)
            ->latest()
            ->take(5)
            ->get();

        // Chart Data
        $chart_data = [
            'mood_trend' => $this->getMoodTrend($userId),
            'mood_distribution' => $this->getMoodDistribution($userId),
            'activity' => $this->getActivityData($userId),
        ];

        // Random motivational quote
        $quotes = [
            "Every diary entry is a step towards self-discovery.",
            "Your feelings are valid. Keep writing.",
            "Consistency is key. Keep the streak going!",
            "Reflect, grow, and shine!",
            "Writing is the painting of the voice.",
        ];
        $quote = $quotes[array_rand($quotes)];

        return view('user.dashboard', compact('stats', 'recent_diaries', 'chart_data', 'quote'));
    }

    private function calculateStreak($userId)
    {
        $diaries = Diary::where('user_id', $userId)
            ->orderBy('created_at', 'desc')
            ->pluck('created_at')
            ->map(fn($date) => Carbon::parse($date)->format('Y-m-d'))
            ->unique()
            ->values();

        if ($diaries->isEmpty()) {
            return 0;
        }

        $streak = 1;
        $today = Carbon::today()->format('Y-m-d');
        
        // Check if wrote today or yesterday
        if ($diaries[0] !== $today && $diaries[0] !== Carbon::yesterday()->format('Y-m-d')) {
            return 0;
        }

        for ($i = 0; $i < $diaries->count() - 1; $i++) {
            $current = Carbon::parse($diaries[$i]);
            $next = Carbon::parse($diaries[$i + 1]);
            
            if ($current->diffInDays($next) === 1) {
                $streak++;
            } else {
                break;
            }
        }

        return $streak;
    }

    private function getMoodLabel($score)
    {
        if ($score >= 80) return 'Sangat Baik';
        if ($score >= 60) return 'Baik';
        if ($score >= 40) return 'Netral';
        if ($score >= 20) return 'Kurang Baik';
        return 'Perlu Perhatian';
    }

    private function getMoodTrend($userId)
    {
        $dates = collect();
        for ($i = 6; $i >= 0; $i--) {
            $dates->push(Carbon::today()->subDays($i));
        }

        $moodData = DiaryAnalysis::whereHas('diary', function($q) use ($userId) {
                $q->where('user_id', $userId);
            })
            ->whereBetween('created_at', [
                Carbon::today()->subDays(6)->startOfDay(),
                Carbon::today()->endOfDay()
            ])
            ->select(
                DB::raw('DATE(created_at) as date'),
                DB::raw('AVG(mood_score) as avg_score')
            )
            ->groupBy('date')
            ->pluck('avg_score', 'date');

        $labels = $dates->map(fn($date) => $date->format('D'))->toArray();
        $data = $dates->map(function($date) use ($moodData) {
            return round($moodData[$date->format('Y-m-d')] ?? 0);
        })->toArray();

        return [
            'labels' => $labels,
            'data' => $data,
        ];
    }

    private function getMoodDistribution($userId)
    {
        $moods = DiaryAnalysis::whereHas('diary', function($q) use ($userId) {
                $q->where('user_id', $userId);
            })
            ->select('mood', DB::raw('count(*) as count'))
            ->groupBy('mood')
            ->pluck('count', 'mood');

        $moodMap = [
            'Senang' => 0,
            'Sedih' => 0,
            'Cemas' => 0,
            'Lelah' => 0,
            'Tenang' => 0,
            'Marah' => 0,
        ];

        foreach ($moods as $mood => $count) {
            $moodMap[ucfirst($mood)] = $count;
        }

        return [
            'labels' => array_keys($moodMap),
            'data' => array_values($moodMap),
        ];
    }

    private function getActivityData($userId)
    {
        $dates = collect();
        for ($i = 29; $i >= 0; $i--) {
            $dates->push(Carbon::today()->subDays($i));
        }

        $activities = Diary::where('user_id', $userId)
            ->whereBetween('created_at', [
                Carbon::today()->subDays(29)->startOfDay(),
                Carbon::today()->endOfDay()
            ])
            ->select(
                DB::raw('DATE(created_at) as date'),
                DB::raw('count(*) as count')
            )
            ->groupBy('date')
            ->pluck('count', 'date');

        $labels = $dates->map(fn($date) => $date->format('d'))->toArray();
        $data = $dates->map(function($date) use ($activities) {
            return $activities[$date->format('Y-m-d')] ?? 0;
        })->toArray();

        return [
            'labels' => $labels,
            'data' => $data,
        ];
    }
}