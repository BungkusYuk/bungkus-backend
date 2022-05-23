<?php

use App\Http\Controllers\AuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/
Route::get('test', function () {
    return ['app' => config('app.name')];
});

Route::post('/login', [AuthController::class, 'login']);
Route::post('/register', [AuthController::class, 'register']);

Route::middleware(['auth:sanctum'])->group(static function () {
    Route::post('/logout', [AuthController::class, 'logout']);
    
    Route::get('test_login', function () {
        return ['app' => config('app.name')];
    });

    Route::apiResource('/addresses', 'AddressesController');
    Route::apiResource('/carts', 'CartsController');
    Route::apiResource('/products', 'ProductsController');
    Route::apiResource('/ratings', 'RatingsController');
    Route::apiResource('/transactions', 'TransactionsController');
    Route::apiResource('/users', 'UsersController');
});
