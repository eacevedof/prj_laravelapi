<?php

use Illuminate\Database\Seeder;
use App\User;
use App\Category;
use App\Product;
use App\Transaction;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     * @return void
     */
    public function run()
    {
        Schema::disableForeignKeyConstraints();
        User::truncate();
        Category::truncate();
        Transaction::truncate();
        Product::truncate();
        
        //uso de facade
        DB::table("category_product")->truncate();
        
        $cantUser = 1000;
        $cantCategories = 30;
        $cantProducts = 2000;
        $cantTransactions = 1000;
        
        factory(User::class,$cantUser)->create();
        $categories = factory(Category::class,$cantCategories)->create();
        
        factory(Product::class,$cantProducts)->create()
                ->each(function($product) use ($categories)
        {
            $categories->random(mt_rand(1,5))->pluck("id");
            $product->categories()->attach($categories);
        });
        
        factory(User::class,$cantUser)->create();
        factory(Transaction::class,$cantTransactions)->create();
        
        Schema::enableForeignKeyConstraints();
    }//run
    
}//DatabaseSeeder
