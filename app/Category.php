<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Product;

class Category extends Model
{
    protected $fillable = [
        "name","description"
    ];
    
    //Relaciones:
    //1 category -> n products
        
    //1 categoria tiene n productos (1:n)
    public function products()
    {
        //tabla n:m category_product
        return $this->belongsToMany(Product::class);
    }
}
