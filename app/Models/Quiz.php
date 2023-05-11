<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Quiz extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'start_date', 'end_date', 'number_of_discs', 'number_of_tries', 'for_who', 'pre_game_link', 'post_game_link', 'creator_id'];

    public function creator()
    {
        return $this->belongsTo(User::class, 'creator_id');
    }

    public function stats()
    {
        return $this->hasMany(Stat::class, 'quiz_id');
    }
}