<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Business extends Model
{
    use HasFactory;
    protected $table= 'business';
   
    protected $guarded = [];
    public function category()
    {
        return $this->belongsTo(Bussiness_category::class, 'business_category_id');
    }
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
