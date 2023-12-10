<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UsersController;
use App\Http\Controllers\ProductsController;
use App\Http\Controllers\TransactionsController;
use App\Http\Controllers\ShoppingCartsController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::controller(AuthController::class)->group(function () {
    Route::post('login', 'login');
    Route::post('logout', 'logout');
    Route::post('refresh', 'refresh');

});


Route::post('/createuser',[UsersController::class,'create_user']);
Route::post('/createproduct',[ProductsController::class,'create_product']);
Route::post('/readproduct',[ProductsController::class,'read_product']);
Route::post('/updateproduct',[ProductsController::class,'update_product']);
Route::post('/deleteproduct',[ProductsController::class,'delete_product']);
Route::post('/createtransaction',[TransactionsController::class,'create_transaction']);
Route::post('/readtransaction',[TransactionsController::class,'read_transaction']);
Route::post('/createorder',[TransactionsController::class,'create_order']);
Route::post('/shopping-cart/create',[ShoppingCartsController::class,'create_cart']);
Route::post('/shopping-cart/read',[ShoppingCartsController::class,'read_cart']);
Route::post('/shopping-cart/delete',[ShoppingCartsController::class,'delete_cart']);

