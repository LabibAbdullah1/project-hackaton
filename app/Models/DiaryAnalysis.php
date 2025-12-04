<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DiaryAnalysis extends Model
{
    use HasFactory;

    protected $table = 'diary_analysis'; 

    protected $fillable = [
        'diary_id',
        'mood',
        'mood_score',
        'reflection',
        'habit_insight',
    ];

    protected $casts = [
        'mood_score' => 'integer',
    ];

    public function diary(): BelongsTo
    {
        return $this->belongsTo(Diary::class);
    }
}
