<?php
//<project>/app/Http/Controllers/Category/CategoryBuyerController.php
namespace App\Http\Controllers\Category;

use App\Buyer;
use App\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CategoryBuyerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param  \App\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function index(Category $category)
    {
        $oCollection = $category->products()
                //whereHas: solo producto que tengan transacciones
                ->whereHas("transactions") //inner join prod on trans
                //solo las transacciones
                ->with("transactions.buyer") //inner join trans on user
                ->get() //ejecuta la consulta
                ->pluck("transactions") //distinct transactions
                ->collapse()
                ->pluck("buyer") //buyer.*
                ->unique("id") //distinct
                ->values()//solo devuelve valores de un array [clave=>valor]
            ;
        return $this->showAll($oCollection);
    }//index

}//CategoryBuyerController
