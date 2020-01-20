<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $fillable = [
        'name', 'description'
    ];
    public function item (){
        return $this->hasMany('App\Item');
        // belongTo that mean from child to parents
    }
}
