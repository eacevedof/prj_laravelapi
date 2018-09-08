<?php
//<project>/app/Http/Controllers/Buyer/BuyerCategoryController.php
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
        $oCollection = $buyer->transactions()
                            ->with("product.categories")
                            ->get()
                            ->pluck("product.categories")
                            ->collapse()
                            ->unique("id") //elimina repetidos
                            ->values() //reorganiza nueva collección y evita blancos donde habia repetidos
                ;
        return $this->showAll($oCollection);
    }//Index

}//BuyerCategoryController
