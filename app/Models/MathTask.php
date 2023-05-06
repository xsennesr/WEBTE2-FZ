<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MathTask extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = [
        'task_name',
        'task',
        'image',
        'solution',
        'batch_id',
    ];
    public static function imageToBase64($image) {
        if(!$image) return null;
        $extension = $image->getClientOriginalExtension();
        $mime = $image->getMimeType();
        $imageData = base64_encode(file_get_contents($image));
        $dataUrl = 'data:' . $mime . ';' . $extension . ';base64,' . $imageData;
        return $dataUrl;
    }

    public function sada(){
        return $this->belongsTo(MathBatch::class);
    }

}
