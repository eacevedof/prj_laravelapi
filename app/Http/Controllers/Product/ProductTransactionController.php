<?php

namespace App\Http\Controllers\Product;

use App\Transaction;
use App\Product;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ProductTransactionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function index(Product $product)
    {
        $oCollection = $product->transactions;
        return $this->showAll($oCollection);
    }//index

}//ProductTransactionController
