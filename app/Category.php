<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Product;
use App\Http\Resources\CategoryResource;

class Category extends Model
{
    public $resource = CategoryResource::class;
    
    protected $fillable = [
        "name","description"
    ];
    
    protected $hidden = [
      "pivot"  
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
