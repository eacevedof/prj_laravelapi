<?php

namespace App\Http\Controllers;

use App\Seller;

class SellerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $oCollection = Seller::has("products")->get();
        return response()->json(["data"=>$oCollection],200);
    }//index

    /**
     * Display the specified resource.
     *
     * @param  \App\Seller  $seller
     * @return \Illuminate\Http\Response
     */
    public function show(Seller $seller)
    {
        return response()->json(["data"=>$seller],200);
    }//show

    //Este metodo es tipo Global Scope
    protected static function boot()
    {
        parent::boot();
    }//boot    
}//SellerController
