<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!

comando: php artisan route:list
*/

/*Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
 * 
 */
Route::apiResource("users","UserController");
Route::apiResource("buyers","BuyerController",["only"=>["index","show"]]);
Route::apiResource("sellers","SellerController",["only"=>["index","show"]]);
Route::apiResource("products","ProductController");
Route::apiResource("transactions","TransactionController");
Route::apiResource("categories","CategoryController");
//Route::get("slug-de-ruta","ProductController@methodX");
