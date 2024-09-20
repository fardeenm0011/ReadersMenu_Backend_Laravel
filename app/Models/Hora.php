<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Hora extends Model
{
    use HasFactory;

    protected $table = 'hora';

 protected $guarded = ['id'];   

     public $timestamps = false;
    protected $primaryKey = 'id';



   


}
