<?php

namespace App;
use App\ShopModel;
use App\User, App\CartModel;

use Illuminate\Database\Eloquent\Model;

class ShopModel extends Model
{
   protected $table = 'tbl_shop';

    // public function user(){
    //     return $this->belongsTo('App\User', 'id');
    // }
    public function cart(){
        return $this->belongsTo('App\CartModel');
    }
    // public function inventory(){
    //     return $this->hasMany('App\ShopModel');
    // }
}
