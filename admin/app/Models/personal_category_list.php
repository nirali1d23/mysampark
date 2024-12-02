<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class personal_category_list extends Model
{
    use HasFactory;
    protected $table="personal_category_list";

    public function personalCategory()
    {
        return $this->belongsTo(PersonalCategory::class, 'personal_category_id');
    }

    public function personalCategoryImages()
    {
        return $this->hasMany(personal_category_image::class, 'personal_category_list_id');
    }
}
