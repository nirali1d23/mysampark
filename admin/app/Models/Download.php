<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Download extends Model
{
    use HasFactory;

    protected $table='download_image';

    protected $fillable = [
        'download_image',
        'bussiness_id',
        'user_id',
        'image_type' 
];
}
