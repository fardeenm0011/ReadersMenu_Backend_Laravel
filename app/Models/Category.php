<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected $table = 'categories';

    protected $fillable = [
        'name',
        'parent_id',
        'status',
        'type',
        'type2',
        'position',
        'isHomepage',
        'sortorder',
        'image',
        'data_query',
        'seo_title',
        'seo_keyword',
        'seo_description',
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

     protected $attributes = array(
        'FullImgPath' => '',
    );

   protected $appends= ['FullImgPath'];

    public function posts()
    {
        return $this->hasMany(Posts::class);
    }

     public function getFullImgPathAttribute()
    {
        if($this->type2 == "news"){
        return url('images/category/news/'. $this->image);
        }
        return url('images/category/artilce/'. $this->image);
    }
}
