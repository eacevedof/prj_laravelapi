<?php

namespace App\Http\Controllers;

use App\Buyer;

class BuyerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $oCollection = Buyer::all();
        return response()->json(["data"=>$oCollection],200);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Buyer  $buyer
     * @return \Illuminate\Http\Response
     */
    public function show(Buyer $buyer)
    {
        return response()->json(["data"=>$buyer],200);
    }

}//BuyerController
