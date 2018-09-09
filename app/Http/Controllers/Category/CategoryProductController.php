<?php
//<project>/app/Http/Controllers/Category/CategoryProductController.php
namespace App\Http\Controllers\Category;

use App\Product;
use App\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CategoryProductController extends Controller
{
    /**
     * Display a listing of the resource.
     * @param  \App\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function index(Category $category)
    {
        $oCollection = $category->products;
        return $this->showAll($oCollection);
    }//index
    
}//CategoryProductController
