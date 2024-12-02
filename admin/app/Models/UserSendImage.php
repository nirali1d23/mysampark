<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserSendImage extends Model
{
    use HasFactory;

    protected $table="user_send_images";

    protected $fillable = ['business_id', 'image_path'];
}
