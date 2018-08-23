<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = [
        "name","description","quantity","status"
        ,"seller_id"
    ];
    
    
}
