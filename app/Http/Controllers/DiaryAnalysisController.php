<?php

namespace App\Http\Controllers;

use App\Models\DiaryAnalysis;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DiaryAnalysisController extends Controller
{
    public function index()
    {
        $analysis = DiaryAnalysis::whereHas('diary', function ($query) {
            $query->where('user_id', Auth::id());
        })
            ->with('diary')
            ->latest()
            ->paginate(15);

        return view('analysis.index', compact('analysis'));
    }

    public function create()
    {
        abort(404); // Halaman tidak ditemukan
    }

    public function store(Request $request)
    {
        abort(404);
    }

    public function show(DiaryAnalysis $diaryAnalysis)
    {
        if ($diaryAnalysis->diary->user_id !== Auth::id()) {
            abort(403, 'Anda tidak memiliki akses ke analisis ini.');
        }

        return view('analysis.show', compact('diaryAnalysis'));
    }

    public function edit(DiaryAnalysis $diaryAnalysis)
    {
        abort(404);
    }

    public function update(Request $request, DiaryAnalysis $diaryAnalysis)
    {
        abort(404);
    }

    public function destroy(DiaryAnalysis $diaryAnalysis)
    {

        if ($diaryAnalysis->diary->user_id !== Auth::id()) {
            abort(403);
        }

        $diaryAnalysis->delete();

        return back()->with('success', 'Hasil analisis KA berhasil dihapus.');
    }
}
