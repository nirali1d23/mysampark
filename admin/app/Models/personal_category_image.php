<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class personal_category_image extends Model
{
    use HasFactory;

    protected $table="personal_category_image";

    public function personalCategoryList()
    {
        return $this->belongsTo(personal_category_list::class, 'personal_category_list_id');
    }
}
