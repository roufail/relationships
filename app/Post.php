<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    //
    protected $fillable = ['title','content','user_id'];
    public function user() {
        return $this->belongsTo(User::class);
    }

    public function categories() {
        return $this->belongsToMany(Category::class);
    }

    public function photos() {
        return $this->morphMany(Photo::class,'photoable');
    }


    public function cover() {
        return $this->photos()->where('type','cover');
    }
}
