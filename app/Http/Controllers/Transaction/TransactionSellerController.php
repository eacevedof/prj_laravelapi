<?php
//<project>/app/Http/Controllers/Transaction/TransactionSellerController.php
namespace App\Http\Controllers\Transaction;

use App\Http\Controllers\Controller;
use App\Seller;
use App\Transaction;
use Illuminate\Http\Request;

class TransactionSellerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param  \App\Transaction  $transaction
     * @return \Illuminate\Http\Response
     */
    public function index(Transaction $transaction)
    {
        $oCollection = $transaction->product->seller;
        //showOne pq de antemano sabemos que es solo un elemento de seller por transacción
        return $this->showOne($oCollection);
        //return $this->showAll($oCollection); 
        //da error: Argument 1 passed to App\Http\Controllers\Controller::showAll() must be an instance of Illuminate\Support\Collection, instance of App\Seller given
        //return $this->showAll($oCollection->get());  va bien
    }//index

}//TransactionSellerController
