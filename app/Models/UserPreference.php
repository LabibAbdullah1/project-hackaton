<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserPreference extends Model
{
    use HasFactory;

    // Pastikan nama tabel sesuai migrasi kamu (user_preferences atau user_preferens)
    // Saya pakai ejaan yang benar (preferences), sesuaikan jika di db kamu beda
    protected $table = 'user_preferences';

    protected $fillable = [
        'user_id',
        'nickname',
        'communication_style', // Formal/Santai
        'interests',
        'motivation_style'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
