<?php



namespace App\Models;



use Illuminate\Database\Eloquent\Factories\HasFactory;

use Illuminate\Database\Eloquent\Model;



class Testimonial extends Model

{

    use HasFactory;

    protected $table= 'testimonial';

   

    
    protected $guarded = [];
    public function getImageAttribute($value)
{
    return url('images/testimonial/' . $value); 
}


 

   


}

