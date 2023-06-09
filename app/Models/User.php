<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'ucitel',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function priklady(){
        return $this->belongsToMany(MathTask::class,'user_math_task')->withPivot('user_id', 'math_task_id', 'user_solution', 'submitted', 'points', 'result');
    }

    public function odovzdane_priklady(){
        return $this->belongsToMany(MathTask::class,'user_math_task')
            ->wherePivot('submitted', true)
            ->withPivot('user_id', 'math_task_id', 'user_solution', 'submitted', 'points', 'result');
    }
}
