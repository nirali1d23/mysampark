<?php



namespace App\Models;



use Illuminate\Database\Eloquent\Factories\HasFactory;

use Illuminate\Database\Eloquent\Model;



class ServiceImges extends Model

{

    use HasFactory;

    protected $table= 'service_images';

   

    protected $guarded = [];

 
  
    public function getimagesAttribute($value)
{
    return url('images/service/' . $value); 
}
   

}

