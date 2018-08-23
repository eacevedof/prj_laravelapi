<?php

namespace App;

use App\User;
use App\Transaction;

class Buyer extends User
{
    //Relaciones:
    //1 buyer -> 1 user
    //1 buyer -> n transactions
        
    //protected $table = "users";
    
    //buyer.no(transaction_id) -> hasMany()
    public function transactions()
    {
        return $this->hasMany(Transaction::class);
        //es lo mismo
        //return $this->hasMany("App\Transaction");
    }
}//Buyer
