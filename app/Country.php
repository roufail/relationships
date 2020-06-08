<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Country extends Model
{
    //
    public function posts() {
        return $this->HasManyThrough(Post::class,User::class);
    }
}
