<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rasi extends Model
{
    use HasFactory;
    protected $table = 'rasi';
    protected $fillable = [
        'name',
        'icon'
    ];
}
