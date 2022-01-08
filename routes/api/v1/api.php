<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\api\v1\LoginController;
use App\Http\Controllers\api\v1\client\ClientController;
use App\Http\Controllers\api\v1\invoice\InvoiceController;
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



// users
Route::prefix('/user')->group(function(){
	Route::post('/login', [LoginController::class, 'login'])->name('login');
});
// invoices
Route::prefix('/invoice')->group(function(){
	Route::post('/create', [InvoiceController::class, 'store'])->middleware('auth:api');
});
// clients
Route::prefix('/client')->group(function(){
	Route::post('/create', [ClientController::class, 'store'])->middleware('auth:api');
});