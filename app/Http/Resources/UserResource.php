<?php
//<project>/app/Http/Resources/UserResource.php
namespace App\Http\Resources;

use App\Http\Resources\BaseResource;

class UserResource extends BaseResource
{
    public static $map = [
        "id" => "identifier",            
        "name" => "full_name",           
        "email" => "email_address",
        "password" => "password",
        "updated_at" => "last_modified",
        "created_at" => "creation_date"
    ];

}//UserResource
