<?php
//<project>/app/Http/Controllers/Seller/SellerTransactionController.php
namespace App\Http\Controllers\Seller;

use App\Transaction;
use App\Seller;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class SellerTransactionController extends Controller
{
    /**
     * Display a listing of the resource.
     * @param  \App\Seller  $seller
     * @return \Illuminate\Http\Response
     */
    public function index(Seller $seller)
    {
        $oCollection = $seller->products()->get()
                ->with("transactions")
        ;
        $this->showAll($oCollection);
    }
}//SellerTransactionController
