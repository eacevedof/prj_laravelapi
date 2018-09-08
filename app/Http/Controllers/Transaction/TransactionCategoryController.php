<?php
//<project>/app/Http/Controllers/Transaction/TransactionCategoryController.php
namespace App\Http\Controllers\Transaction;

use App\Category;
use App\Transaction;
use Illuminate\Http\Request;

class TransactionCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param  \App\Transaction  $transaction
     * @return \Illuminate\Http\Response
     */
    public function index(Transaction $transaction)
    {
        $oCollection = $transaction->product->categories;
        return $this->showAll($oCollection);
    }//index

}//TransactionCategoryController
