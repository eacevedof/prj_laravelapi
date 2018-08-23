<?php

use Faker\Generator as Faker;

$factory->define(App\Product::class, function (Faker $faker) {
    return [
        "name" => $faker->word,
        "description" => $faker->paragraph(1),
        "quantity" => $faker->numberBetween(1,10),
        //mala práctica, mejor definirlos como constantes en el modelo
        //"status" => $faker->randomElement(["disponible","no_disponible"]),
        //"status" => $faker->randomElement(["si","no"]),
        
        "status" => $faker->randomElement([Product::AVAILABLE,Product::NOT_AVAILABLE]),
        //de todos los usuarios obten uno y de ese id
        "seller_id" => User::all()->random()->id,
        //es lo mismo que el anterior
        //"seller_id" => User::inRandomOrder()->first()->id,
    ];
});
