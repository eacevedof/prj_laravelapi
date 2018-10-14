<?php

namespace App\Http\Resources;

use App\Http\Resources\BaseResource;

class SellerResource extends BaseResource
{
    public static $map = [
        "id" => "identifier",            
        "name" => "full_name",           
        "email" => "email_address",
        "updated_at" => "last_modified",
        "created_at" => "creation_date" 
    ];
    
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $transform = parent::toArray($request);
        
        $hateoas = [
            "links" => [
                "rel" => "self",
//  sellers/{seller} => sellers.show               
                "href" => route("sellers.show",$this->id),
            ]
        ];
        
        $transform = array_merge($transform,$hateoas);
        return $transform;
    }        
}//SellerResource
