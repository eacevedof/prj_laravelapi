<?php

namespace App;

use App\User;
use App\Product;
use App\Scopes\SellerScope;
use App\Http\Resources\SellerResource;

class Seller extends User
{
    public $resource = SellerResource::class;    
    //protected $table = "users";
    //$fillable es el mismo que user luego no se configura
    //Relaciones:
    //1 seller -> 1 user
    //1 seller -> n products    
    
    //Este metodo es tipo Global Scope y se ejecuta siempre
    protected static function boot()
    {
        parent::boot();
        static::addGlobalScope(new SellerScope);
    }//boot
        
    //seller.no(product_id) -> hasMany()
    public function products()
    {
        return $this->hasMany(Product::class);
    }
    
}//Seller
