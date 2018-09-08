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
     *
     * @param  \App\Buyer  $buyer
     * @return \Illuminate\Http\Response
     */
    public function index(Buyer $buyer)
    {
        $oCollection = $buyer->transactions->product->seller;
        return $this->showAll($oCollection);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @param  \App\Buyer  $buyer
     * @return \Illuminate\Http\Response
     */
    public function create(Buyer $buyer)
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Buyer  $buyer
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Buyer $buyer)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Buyer  $buyer
     * @param  \App\Seller  $seller
     * @return \Illuminate\Http\Response
     */
    public function show(Buyer $buyer, Seller $seller)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Buyer  $buyer
     * @param  \App\Seller  $seller
     * @return \Illuminate\Http\Response
     */
    public function edit(Buyer $buyer, Seller $seller)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Buyer  $buyer
     * @param  \App\Seller  $seller
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Buyer $buyer, Seller $seller)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Buyer  $buyer
     * @param  \App\Seller  $seller
     * @return \Illuminate\Http\Response
     */
    public function destroy(Buyer $buyer, Seller $seller)
    {
        //
    }
}
