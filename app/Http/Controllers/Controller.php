<?php
//<project>\app\Http\Controllers\Controller.php
namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use App\Traits\ApiResponser;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests, ApiResponser;

    private function checkSeller(Seller $seller, Product $product)
    {
        if($seller->id != $product->seller_id) 
            //throw new HttpException(422, "The specified seller is not the actual seller of this product");
            //mejor 403 operación no permitida
            throw new HttpException(403,"The specified seller is not the actual seller of this product");
    }//checkSeller
}//Controller
