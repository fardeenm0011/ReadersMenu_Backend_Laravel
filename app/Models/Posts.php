<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Posts extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'category_id',
        'title',
        'subTitle',
        'description',
        'img',
        'popular',
        'status',
        'isBreaking',
        'readStatus',
        'isActive',
        'seo_slug',
        'seo_title',
        'seo_keyword',
        'seo_description'
    ];

     
     protected $attributes = array(
        'FullImgPath' => '',
         'BlogURL' => '',
    );

   protected $appends= ['FullImgPath','BlogURL'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function comments()
    {
        return $this->hasMany(Comments::class);
    }
    public function likes()
    {
        return $this->hasMany(Likes::class);
    }

    protected function description(): Attribute
    {
        return Attribute::make(
            get: fn (string $value) => strip_tags($value),
        );
    }

   
 public function getFullImgPathAttribute()
    {
        if($this->category){
            if($this->category->type2 == "news"){
            return url('images/post/news_detail/'. $this->img);
        }
        return url('images/post/article_detail/'. $this->img);
        }

        return "";
    }
    


       
 public function getBlogURLAttribute()
    {

        if($this->category){
             if($this->category->type == 'news'){
            return url('news_detail/'. $this->seo_slug);
        }
        return "https://readersmenu.com/article_detail/". $this->seo_slug;
        }
        return null;
       
    }

    
     
}
