<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class BuyerResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        //return parent::toArray($request);
        return [
            "identifier" => $this->id,
            "full_name" => $this->name,
            "email_address" => $this->email,
            "last_modified" => (string)$this->updated_at,
            "creation_date" => (string)$this->created_at,
            "is_active" => TRUE,
        ];        
    }
}//BuyerResource
