<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    protected $fillable = ['name', 'title','text'];

   public function images()
   {
       return $this->hasMany('App\Image');
   }

   public function comments()
   {
       return $this->hasMany('App\Comment');
   }
}
