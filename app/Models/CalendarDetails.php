<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CalendarDetails extends Model
{
    use HasFactory;
    protected $table = 'calendar_details';
    protected $fillable = [
        'calendar_data',
        'calendar_date'
    ];
}
