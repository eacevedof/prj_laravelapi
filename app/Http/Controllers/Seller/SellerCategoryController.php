<?php
//<project>/app/Http/Controllers/Seller/SellerCategoryController.php
namespace App\Http\Controllers\Seller;

use App\Category;
use App\Seller;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class SellerCategoryController extends Controller
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
                ->whereHas("categories")  //products.id = cateogory_product.product_id
                ->with("categories")      //categories.*
                ->get()
                ->pluck("categories")     //extrae los arrays de categories del array de arrays
                ->collapse()              //quita los indices
                ->unique("id")            //distinct
                ->values()                //solo valores
        ;
        //dd($oCollection);
        return $this->showAll($oCollection);
    }

}//SellerCategoryController
