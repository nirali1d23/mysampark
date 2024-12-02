<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
    protected $table= 'product';
   
    protected $guarded = [];

    public function prodcutimages()
    {
        return $this->hasMany(ProductImages::class, 'product_id');
    }


   
}
