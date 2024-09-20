<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MpeoplesContact extends Model
{
    use HasFactory;
    protected $table = 'mpeoples_contact';

    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'message',
        'gender',
        'birthday',
        'college_name',
        'college_location',
        'degree',
        'degree_name',
        'address',
        'course_interests',
        'type'
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

}
