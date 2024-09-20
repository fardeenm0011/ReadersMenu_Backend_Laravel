<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Panchangam extends Model
{
    use HasFactory;
    protected $table = 'panchangam';

    protected $fillable = [
        'info',
    ];
    protected $casts = [
        'created_at' => 'datetime',
    ];
}
