<?php

namespace App\Models;

use Laravel\Sanctum\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'api_token'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
    public function quizzes()
    {
        return $this->hasMany(Quiz::class, 'creator_id');
    }

    public function stats()
    {
        return $this->hasMany(Stat::class, 'player_id');
    }
    public function isSuperAdmin()
    {
        return $this->role == 'superadmin';
    }
    public function isAdmin()
    {
        return $this->role == 'admin';
    }
    public function isProfessor()
    {
        return $this->role == 'professor';
    }
    public function isStudent()
    {
        return $this->role == 'student';
    }
}
