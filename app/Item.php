<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    protected $fillable = [
        'sku','name', 'description','image','price','discount','views','status','category_id'
    ];
    public function card (){
        return $this->belongsTo('App\Card'); // name of model
        // belongTo that mean from child to parents
    }
    public function category (){
        return $this->belongsTo('App\Category'); // name of model
    }
}
