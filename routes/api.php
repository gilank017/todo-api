<?php

use App\Http\Controllers\API\UsersController;
use App\Http\Controllers\API\ProductsController;
use App\Http\Controllers\API\InvoiceController;
use App\Http\Controllers\API\InvoiceDetailsController;
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

Route::apiResource('users', UsersController::class);
Route::apiResource('products', ProductsController::class);
Route::apiResource('invoice', InvoiceController::class);
Route::apiResource('invoice-detail', InvoiceDetailsController::class);

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
