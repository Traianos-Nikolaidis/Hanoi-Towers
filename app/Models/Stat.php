<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Stat extends Model
{
    use HasFactory, SoftDeletes;
    protected $dates = ['deleted_at'];
    protected $fillable = ['player_id', 'quiz_id', 'correct_moves', 'wrong_moves', 'time_played', 'ip_address', 'date_played', 'completed'];

    public function player()
    {
        return $this->belongsTo(User::class, 'player_id');
    }

    public function quiz()
    {
        return $this->belongsTo(Quiz::class, 'quiz_id');
    }
}