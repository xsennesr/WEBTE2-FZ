<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MathBatch extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = [
        'name',
        'max_points',
        'publishing_at',
        "closing_at",
    ];

    public function priklady(){
        return $this->hasMany(MathTask::class,'batch_id');
    }

}
