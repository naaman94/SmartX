<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $guarded = [];

    //
    public function user (){
        return $this->belongsTo('App\User'); // name of model
        // belongTo that mean from child to parents
    }

    public function card (){
    return $this->hasMany('App\Card'); // name of model
}

}
