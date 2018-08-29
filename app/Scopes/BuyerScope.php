<?php
namespace App\Scopes;

use Illuminate\Database\Eloquent\Scope;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class BuyerScope implements Scope
{

    //se va a ejecutar cada vez que se desee crear una instancia
    public function apply(Builder $builder, Model $model) 
    {
        $builder->has("transactions");
    }//apply

}//BuyerScope
