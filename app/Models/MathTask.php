<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MathTask extends Model
{
    use HasFactory;
    protected $fillable = [
        'batch_name',
        'task_name',
        'task',
        'image',
        'solution',
        'max_points',
    ];
}
