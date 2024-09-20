<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BaseSetting extends Model
{
    use HasFactory;
    protected $table = 'base_setting';

    protected $fillable = [
        'site_title',
        'site_logo',
        'site_favicon',
        'seo_keyword',
        'seo_title',
        'seo_description',
        'email',
        'address',
        'phone_number',
        'social_fb',
        'social_insta',
        'social_google',
        'social_linkedin',
        'social_twitter',
        'social_telegram',
        'social_whatsapp'
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

}
