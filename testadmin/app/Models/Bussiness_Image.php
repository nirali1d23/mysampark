<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bussiness_Image extends Model
{
    use HasFactory;

    protected $table='image_category';
    protected $fillable = [
        'name' ];
      
}
