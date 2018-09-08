<?php

namespace App\Http\Controllers\Buyer;

use App\Product;
use App\Buyer;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class BuyerProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param  \App\Buyer  $buyer
     * @return \Illuminate\Http\Response
     */
    public function index(Buyer $buyer)
    {
        //se esta obteniendo una colleccion de transactions
        //transactions():ret $this->hasMany(Transaction::class); 
        //  with("product"): Transaction.product() 
        //      ret $this->belongsTo(Product::class)
        $oCollection = $buyer->transactions()
                            ->with("product")
                            ->get()
                            ->pluck("product");
        return $this->showAll($oCollection);
    }//index
}//BuyerProductController
