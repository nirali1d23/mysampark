<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Image extends Model
{
    use HasFactory;
    protected $table="image";
    protected $guarded = [];
        public function categoryimage()
    {
        return $this->belongsTo(Bussiness_Image::class, 'category_id');
    }
    protected static function boot()
    {
        parent::boot();
        static::deleting(function ($image) {
            $image->categoryimage()->delete();
           
        });
    }

}
