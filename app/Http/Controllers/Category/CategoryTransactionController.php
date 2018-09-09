<?php
//<project>/app/Http/Controllers/Category/CategoryTransactionController.php
namespace App\Http\Controllers\Category;

use App\Transaction;
use App\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CategoryTransactionController extends Controller
{
    /**
     * Display a listing of the resource.
     * @param  \App\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function index(Category $category)
    {
        $oCollection = $category->products()
                        //whereHas: solo producto que tengan transacciones
                        ->whereHas("transactions")
                        //solo las transacciones
                        ->with("transactions")
                        ->get() //ejecuta la consulta
                        ->pluck("transactions")
                        ->collapse()
                ;
        return $this->showAll($oCollection);
    }//index

}//CategoryTransactionController
