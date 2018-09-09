<?php
//<project>/app/Http/Controllers/Category/CategorySellerController.php
namespace App\Http\Controllers\Category;

use App\Seller;
use App\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CategorySellerController extends Controller
{
    /**
     * Display a listing of the resource.
     * @param  \App\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function index(Category $category)
    {
        $oCollection = $category->products()
                ->with("seller")->get()
                ->pluck("seller")
                ->unique("id")
                ->values()
            ;
        return $this->showAll($oCollection);
    }//index
    
}//CategorySellerController
