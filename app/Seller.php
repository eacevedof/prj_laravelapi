<?php

namespace App;

use App\User;
use App\Product;

class Seller extends User
{
    //protected $table = "users";
    //$fillable es el mismo que user luego no se configura
    //Relaciones:
    //1 seller -> 1 user
    //1 seller -> n products    
    
    //seller.no(product_id) -> hasMany()
    public function products()
    {
        return $this->hasMany(Product::class);
    }
    
}//Seller
