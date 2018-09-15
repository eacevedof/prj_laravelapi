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
        //dd($seller);die;
        $oCollection = $seller->products()
                ->whereHas("transactions")
                ->with("transactions")
                ->get()
                ->pluck("transactions")
                ->collapse()
        ;
        //dd($oCollection);
        return $this->showAll($oCollection);
    }
}//SellerTransactionController
