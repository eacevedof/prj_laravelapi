<?php
namespace App;

use App\User;
use App\Transaction;
use App\Scopes\BuyerScope;

class Buyer extends User
{
    //Relaciones:
    //1 buyer -> 1 user
    //1 buyer -> n transactions
        
    //protected $table = "users";
    
    //Este metodo es tipo Global Scope y se ejecuta siempre
    protected static function boot()
    {
        parent::boot();
        static::addGlobalScope(new BuyerScope);
    }//boot
        
    //buyer.no(transaction_id) -> hasMany()
    public function transactions()
    {
        return $this->hasMany(Transaction::class);
        //es lo mismo
        //return $this->hasMany("App\Transaction");
    }//transactions
    
}//Buyer
