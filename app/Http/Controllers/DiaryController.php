<?php

namespace App\Http\Controllers;

use App\Models\Diary;
use App\Jobs\AnalyzeDiaryMoodJob;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DiaryController extends Controller
{

    public function store(Request $request)
    {
        $request->validate([
            'content' => 'required|string|min:10',
            'is_private' => 'required|boolean',
        ]);

        $diary = Diary::create([
            'user_id' => Auth::id(),
            'content' => $request->input('content'),
            'is_private' => $request->input('is_private'),
        ]);

        AnalyzeDiaryMoodJob::dispatch($diary->id);

        return redirect()->route('dashboard')->with('success', 'Diary Anda sedang dianalisis.');
    }
}
