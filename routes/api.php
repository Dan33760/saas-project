<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\KybController;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\StoreController;
use App\Http\Controllers\Api\ProductController;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/login', [AuthController::class, 'loginUser']);
Route::post('/register', [AuthController::class, 'registerUser'])->name('user.add');
Route::post('/add_client', [AuthController::class, 'registerUser']);

Route::middleware('auth:sanctum')->group( function () {
    Route::get('/profil', [UserController::class, 'profilUser']);
    Route::post('/update_profil', [UserController::class, 'updateUser']);
    Route::post('/update_image', [UserController::class, 'updateProfilImage']);
});

# Route For Tenant
Route::middleware('auth:sanctum')->prefix('tenant')->group( function () {
    Route::post('/add_store', [StoreController::class, 'addStore']);
    Route::post('/update_store/{id}', [StoreController::class, 'updateStore']);
    Route::get('/delete_store/{id}', [StoreController::class, 'deleteStore']);
    Route::get('/active_store/{id}', [StoreController::class, 'activeStore']);

    Route::post('/add_kyb', [KybController::class, 'addKyb']);

    Route::post('/add_product', [ProductController::class, 'addProduct']);
    Route::post('/update_product/{id}', [ProductController::class, 'updateProduct']);
    Route::get('/delete_product/{id}', [ProductController::class, 'deleteProduct']);
    Route::get('/active_product/{id}', [ProductController::class, 'activeProduct']);
});