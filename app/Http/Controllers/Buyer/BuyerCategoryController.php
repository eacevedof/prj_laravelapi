<?php

namespace App\Http\Controllers\Buyer;

use App\Category;
use App\Buyer;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class BuyerCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param  \App\Buyer  $buyer
     * @return \Illuminate\Http\Response
     */
    public function index(Buyer $buyer)
    {
        $oCollection = $buyer->transactions->product->categories;
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
     * @param  \App\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function show(Buyer $buyer, Category $category)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Buyer  $buyer
     * @param  \App\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function edit(Buyer $buyer, Category $category)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Buyer  $buyer
     * @param  \App\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Buyer $buyer, Category $category)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Buyer  $buyer
     * @param  \App\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function destroy(Buyer $buyer, Category $category)
    {
        //
    }
}
