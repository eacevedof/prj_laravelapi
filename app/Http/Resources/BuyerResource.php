<?php
//<project>\app\Http\Resources\BuyerResource.php
namespace App\Http\Resources;

use App\Http\Resources\BaseResource;

class BuyerResource extends BaseResource
{
    public static $map = [
        "id" => "identifier",            
        "name" => "full_name",           
        "email" => "email_address",
        "updated_at" => "last_modified",
        "created_at" => "creation_date" 
    ];
    
    //se usa en BaseResource.toArray(request)
    public function generateLinks($request)
    {
        return [
            [
                "rel" => "self",
                "href"=> route("buyers.show",$this->id),
            ],
            [
                "rel" => "buyers.categories",
                "href"=> route("buyers.categories.index",$this->id),
            ],
            [
                "rel" => "buyers.products",
                "href"=> route("buyers.products.index",$this->id),
            ],
            [
                "rel" => "buyers.sellers",
                "href"=> route("buyers.sellers.index",$this->id),
            ],
            [
                "rel" => "buyers.transactions",
                "href"=> route("buyers.transactions.index",$this->id),
            ],
            [
                "rel" => "users",
                "href"=> route("users.show",$this->id),
            ]
        ];
    }//generateLinks
    
}//BuyerResource
