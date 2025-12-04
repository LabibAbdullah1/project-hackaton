<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Mood extends Model
{
    use HasFactory;

    protected $fillable = 'mood_name';

    public function aiRespons()
    {
        return $this->hasMany(AiRespons::class);
    }

}
