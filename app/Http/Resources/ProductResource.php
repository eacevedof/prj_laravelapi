<?php

namespace App\Http\Resources;

use App\Http\Resources\BaseResource;

class ProductResource extends BaseResource
{
    /*
    "name","description","quantity","status"
    ,"seller_id"
    */
    public static $map = [
        "id" => "identifier",            
        "name" => "title",           
        "description" => "details",
        "quantity" => "stock",
        "status" => "situation",
        "seller_id" => "seller",
        "updated_at" => "last_modified",
        "created_at" => "creation_date" 
    ];
    
        //se usa en BaseResource.toArray(request)
    public function generateLinks($request)
    {
        return [
            [
                "rel" => "self",
                "href"=> route("products.show",$this->id),
            ],
            [
                "rel" => "products.buyers",
                "href"=> route("products.buyers.index",$this->id),
            ],            
            [
                "rel" => "products.categories",
                "href"=> route("products.categories.index",$this->id),
            ],
            [
                "rel" => "products.transactions",
                "href"=> route("products.transactions.index",$this->id),
            ],
            [
                "rel" => "seller",
                "href"=> route("sellers.show",$this->seller_id),
            ]
        ];
    }//generateLinks   
    
}//ProductResource
