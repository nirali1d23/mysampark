<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Frame extends Model
{
    use HasFactory;

    protected $table="frames";

    protected $guarded = [];

    public function ratiosapp()
{
    return $this->hasMany(FrameRatioApp::class, 'frame_id');
}
 public function frame_icon()
    {
        return $this->hasMany(Frameicon::class, 'frame_id');
    }

    protected static function booted()
    {
        static::deleting(function ($frame) {
            // Delete related FrameRatioApp records
            $frame->ratiosapp()->delete();

            // Delete related Frameicon records
            $frame->frame_icon()->delete();
        });
    }

    
}
