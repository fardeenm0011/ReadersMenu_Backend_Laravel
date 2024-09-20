<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AdditionalDayInfo extends Model
{
    use HasFactory;
    protected $table = 'additional_day_info';

    protected $fillable = [
        'astami_info',
        'navami_info',
        'kari_info',
        'vasthu_info',
        'year'
    ];
}
