<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Buyer;
use App\Product;
use App\Http\Resources\TransactionResource;

class Transaction extends Model
{
    public $resource = TransactionResource::class;
        
    protected $fillable = [
        "quantity","buyer_id","product_id"
    ];
    
    //Relaciones:
    //1 transaction -> 1 product
    
    //transaction.buyer_id -> belongsTo()
    public function buyer()
    {
        return $this->belongsTo(Buyer::class);
    }
    
    //transaction.product_id -> belongsTo
    public function product()
    {
        return $this->belongsTo(Product::class);
    }    
    
}//Transaction
