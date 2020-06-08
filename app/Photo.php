<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Photo extends Model
{
    protected $fillable = ['src','type'];
    //
    public function photoable(){
        return $this->morphTo();
    }

}
