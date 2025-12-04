<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AiRespons extends Model
{
    use HasFactory;

    protected $table = 'ai_respons';

    protected $fillable = [
        'user_id',
        'mood_id',
        'user_message',
        'ka_reply',
        'motivation',
        'processing_time_ms'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function mood()
    {
        return $this->belongsTo(Mood::class);
    }
}
