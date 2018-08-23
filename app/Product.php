<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    const AVAILABLE = "available";
    const NOT_AVAILABLE = "not available";
    
    protected $fillable = [
        "name","description","quantity","status"
        ,"seller_id"
    ];
    
}//Product
