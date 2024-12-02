<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PersonalCategory extends Model
{
    use HasFactory;
   
    protected $table="pesonal_category";
    protected $fillable = [
        'id',
    'name' ];

    public function personalCategoryLists()
    {
        return $this->hasMany(personal_category_list::class, 'personal_category_id');
    }
}
