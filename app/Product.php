<?php
namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Seller;
use App\Category;
use App\Transaction;
use App\Http\Resources\ProductResource;

class Product extends Model
{
    public $resource = ProductResource::class;
        
    const AVAILABLE = "available";
    const NOT_AVAILABLE = "not available";
    
    protected $fillable = [
        "name","description","quantity","status"
        ,"seller_id"
    ];
    
    protected $hidden = [
      "pivot"  
    ];    
    
    //Relaciones:
    //1 product -> 1 seller
    //1 product -> n categories
    //1 product -> n transactions
    
    //product.seller_id -> belongsTo()
    public function seller()
    {
        return $this->belongsTo(Seller::class);
    }
       
    //product.no(transaction_id) -> hasMany()
    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }   
    
    //product - categories (n:m) -> belongsToMany()
    public function categories()
    {
        //tabla n:m category_product
        return $this->belongsToMany(Category::class);
    }    
   
}//Product
