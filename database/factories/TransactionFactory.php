<?php
use Faker\Generator as Faker;

$factory->define(App\Transaction::class, function (Faker $faker) {
    //No uso User pq no tiene relación directa con Transactions
    //Como laravel sabe que Seller tiene Products?. 
    //Esto se hace despues, al configurar las fks en los modelos
    $seller = Seller::has("products")->get()->random();
    $buyer = User::all()->except($seller->id)->random();
    
    return [
        "quantity" => $faker->numberBetween(1,3),
        "buyer_id" => $buyer->id,
        "product_id"=> $seller->products->random()->id,
    ];
});
