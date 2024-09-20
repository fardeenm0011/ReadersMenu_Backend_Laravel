<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CalendarImages extends Model
{
    use HasFactory;
    protected $table = 'calendar_images';


     protected $attributes = array(
        'FullImgPath' => ''
    );

   protected $appends= ['FullImgPath'];


    public function getFullImgPathAttribute()
    {
        return url('images/calendar/'.$this->year.'/'.$this->img_name);
    }
    
}
