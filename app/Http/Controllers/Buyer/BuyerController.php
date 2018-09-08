<?php
//<project>/app/Http/Controllers/Buyer/BuyerController.php
namespace App\Http\Controllers\Buyer;

use App\Buyer;

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
        return $this->showAll($oCollection);
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
