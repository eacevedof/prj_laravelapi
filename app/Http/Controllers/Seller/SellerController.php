<?php
//<project>/app/Http/Controllers/Seller/SellerController.php
namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use App\Seller;
use App\Http\Resources\SellerResource;

class SellerController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $oCollection = Seller::all();
        $oCollection = SellerResource::collection($oCollection);
        return $oCollection;
    }//index

    /**
     * Display the specified resource.
     * @param  \App\Seller  $seller
     * @return \Illuminate\Http\Response
     */
    public function show(Seller $seller)
    {
        return $this->showOne($seller);
    }//show

    //duda... va?
    //Este metodo es tipo Global Scope
    protected static function boot()
    {
        parent::boot();
    }//boot    

}//SellerController
