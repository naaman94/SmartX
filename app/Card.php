<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Card extends Model
{
    protected $guarded = [];

    public function order (){
        return $this->belongsTo('App\Order'); // name of model
        // belongTo that mean from child to parents
    }
    public function item (){
        return $this->belongsTo('App\Item'); // name of model
    }
}
