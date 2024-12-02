<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Frameicon extends Model
{
    use HasFactory;
    
    protected $table="frames_icons";
    
     protected $guarded = [];
     

       public function frames()
    {
        return $this->belongsTo(Frame::class, 'frame_id');
    }
}
