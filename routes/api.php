<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\GroceryListController;

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

Route::group(['prefix' => 'auth', 'middleware'=>'api'], function () {
    Route::post('create', [AuthController::class, 'create']);
    Route::post('me', [AuthController::class, 'me']);
    Route::post('login', [AuthController::class, 'login']);
    Route::post('logout', [AuthController::class, 'logout']);
});

Route::middleware(['middleware'=>'api'])->group(function () 
{
    Route::group(['prefix' => 'track'], function () {
        Route::post('store', [GroceryListController::class, 'store']);
        Route::get('get', [GroceryListController::class, 'get']);
        Route::delete('delete', [GroceryListController::class, 'delete']);
        Route::put('put', [GroceryListController::class, 'put']);

    });
});

