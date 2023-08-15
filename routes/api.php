<?php

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\InvoiceController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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
// Public Routes
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

// Admin Routes
Route::middleware(['auth:sanctum', 'admin'])->group(function () {
    Route::get('/admin/auth', function (Request $request) {
        return $request->user();
    });
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::apiResource('/product', ProductController::class);
    Route::get('/get/product', [ProductController::class,'allProduct']);
    Route::apiResource('/invoice', InvoiceController::class)->only('index','store');


});
// Frontend Routes
Route::group(['prefix' => 'frontend'], function () {
    Route::get('/products', [\App\Http\Controllers\Front\FrontEndController::class, 'getProducts']);
});
Route::get('/user/auth', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');
