<?php
//<project>/app/Http/Controllers/Seller/SellerCategoryController.php
namespace App\Http\Controllers\Seller;

use App\Buyer;
use App\Seller;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class SellerBuyerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param  \App\Seller  $seller
     * @return \Illuminate\Http\Response
     */
    public function index(Seller $seller)
    {
        $oCollection = $seller->products()  //products.seller_id = s.id
                ->whereHas("transactions")  //products.id = transactions.product_id
                //->with("transactions.buyer") //transactions.buyer_id = users.id
                ->get()                      //devuelve el array de transacciones
                ->pluck("transactions")     //extrae los arrays de transactions del array de arrays
                ->collapse()              //quita los indices
                ->pluck("buyer")            //buyers.*
                ->unique("id")            //distinct
                ->values()                //solo valores
        ;
        //dd($oCollection);
        return $this->showAll($oCollection);
    }
}//SellerBuyerController
