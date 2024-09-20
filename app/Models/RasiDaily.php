<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RasiDaily extends Model
{
    use HasFactory;

    protected $table = 'rasi_daily';
    protected $fillable = [
        'rasi_id',
        'info',
        'rasi_date'
    ];
}
