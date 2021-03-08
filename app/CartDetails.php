<?php

namespace App;
use App\User, App\ShopModel, App\CartModel;
use Illuminate\Database\Eloquent\Model;

class CartDetails extends Model
{
    protected $table = 'tbl_cart';
    public function inventory(){
        return $this->hasMany('App\ShopModel');
    }

    public function cart()
    {
        return $this->hasMany('App\ShopModel');
    }
}
