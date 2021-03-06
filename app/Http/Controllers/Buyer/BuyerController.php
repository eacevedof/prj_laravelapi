<?php
//<project>/app/Http/Controllers/Buyer/BuyerController.php
namespace App\Http\Controllers\Buyer;

use App\Http\Controllers\Controller;
use App\Buyer;
use App\Http\Resources\BuyerResource;

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
        $oCollection = BuyerResource::collection($oCollection);
        return $oCollection;
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Buyer  $buyer
     * @return \Illuminate\Http\Response
     */
    public function show(Buyer $buyer)
    {
        return $this->showOne($buyer);
    }

}//BuyerController
