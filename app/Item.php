<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    protected $guarded = [];


    public function card (){
        return $this->hasMany('App\Card'); // name of model
        // belongTo that mean from child to parents
    }
    public function category (){
        return $this->belongsTo('App\Category'); // name of model
    }
}
