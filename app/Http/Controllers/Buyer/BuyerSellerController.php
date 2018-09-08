<?php

namespace App\Http\Controllers\Buyer;

use App\Seller;
use App\Buyer;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class BuyerSellerController extends Controller
{
    /**
     * Display a listing of the resource.
     * @param  \App\Buyer  $buyer
     * @return \Illuminate\Http\Response
     */
    public function index(Buyer $buyer)
    {
        $oCollection = $buyer->transactions()
                            ->with("product.seller")
                            ->get()
                            ->pluck("product.seller")
                            ->unique("id") //elimina repetidos
                            ->values() //reorganiza nueva collección y evita blancos donde habia repetidos
                ;
        return $this->showAll($oCollection);
    }//index
    
}//BuyerSellerController
