<?php

namespace App\Http\Controllers;

use App\Seller;

class SellerController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $oCollection = Seller::has("products")->get();
        return $this->showAll($oCollection);
    }//index

    /**
     * Display the specified resource.
     * @param  \App\Seller  $seller
     * @return \Illuminate\Http\Response
     */
    public function show(Seller $seller)
    {
        return $this->showOne($buyer);
    }//show

    //duda... va?
    //Este metodo es tipo Global Scope
    protected static function boot()
    {
        parent::boot();
    }//boot    

}//SellerController
