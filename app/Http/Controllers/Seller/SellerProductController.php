<?php
//<project>/app/Http/Controllers/Seller/SellerProductController.php
namespace App\Http\Controllers\Seller;

use App\Product;
use App\Seller;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Symfony\Component\HttpKernel\Exception\HttpException;
use App\Http\Resources\ProductResource;

class SellerProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param  \App\Seller  $seller
     * @return \Illuminate\Http\Response
     */
    public function index(Seller $seller)
    {
        $oCollection = $seller->products;  //products.seller_id = s.id
        //dd($oCollection);
        return $this->showAll($oCollection);
    }//index

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Seller  $seller
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Seller $seller)
    {
        $rules = [
            "name" => "required|max:255",
            "description" => "required|max:1000",
            "quantity" => "required|integer|min:1",
        ];
        
        $data = $this->transformAndValidateRequest(ProductResource::class, $request, $rules);
        //El producto tiene un estado: Disponible o No disponible. 
        //Para que esté disponible debe tener al menos una categoria
        $data["status"] = Product::NOT_AVAILABLE;
        $data["seller_id"] = $seller->id; //el seller_id no se recupera de la url
        
        $product = Product::create($data);
        
        return $this->showOne($product,201);
        
    }//store

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Seller  $seller
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Seller $seller, Product $product)
    {
        $rules = [
            "name" => "max:255",
            "description" => "max:1000",
            "quantity" => "integer|min:1",
            //esto obliga a que status tenga solo estos valores
            "status" => "in:" . Product::AVAILABLE . "," . Product::NOT_AVAILABLE
        ];    
        
        $data = $this->transformAndValidateRequest(ProductResource::class, $request, $rules);
        //tenemos que verificar si la persona que hace la actualizacion es la propietaria del producto
        //se puede hacer por "policies"
        //Este método disparará una excepción y como aqui no estoy tratandola se ejecutará el Handler (//<project>/app/Exceptions/Handler.php)
        $this->checkSeller($seller,$product);
        
        //no tratamos el estado aqui pq más adelaten se tratará 
        //$product->fill($request->only(["name","description","quantity"]));
        $product->fill($data); //versión mejorada
        
        //si el estado va a cambiar a disponible tenemos que verificar que el producto tenga una categoria
        //se ha pasado a disponible pero no tiene categorias
        if($product->status == Product::AVAILABLE && $product->categories()->count()===0)
            return $this->errorResponse ("An active product must have at least one category",409);
        
        //el producto no ha cambiado
        if($product->isClean())
            return $this->errorResponse ("Please specify at least one new value to update",422);
        
        $product->save();
        
        return $this->showOne($product);
    }//update
    
    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Seller  $seller
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(Seller $seller, Product $product)
    {
        //tenemos que elimnar el producto asociado a un vendedor
        $this->checkSeller($seller, $product);
        $product->delete();
        return $this->showOne($product);
    }//destroy
    
    private function checkSeller(Seller $seller, Product $product)
    {
        if($seller->id != $product->seller_id) 
            //throw new HttpException(422, "The specified seller is not the actual seller of this product");
            //mejor 403 operación no permitida
            throw new HttpException(403,"The specified seller is not the actual seller of this product");
    }//checkSeller
        
}//SellerProductController
