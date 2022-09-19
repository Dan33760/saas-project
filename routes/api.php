<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\KybController;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\AdminController;
use App\Http\Controllers\Api\StoreController;
use App\Http\Controllers\Api\ClientController;
use App\Http\Controllers\Api\TenantController;
use App\Http\Controllers\Api\ProductController;
use App\Http\Controllers\Api\ShoppingCartController;

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
// Default route
Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

//++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
// ROute pour verifier l'email  |
//______________________________|
Route::get('/email/verify', function () {
    return view('auth.verify-email');
})->middleware('auth:sanctum')->name('verification.notice');
 
Route::get('/email/verify/{id}/{hash}', [AuthController::class, 'verifyEmail'])
        ->middleware(['auth:sanctum', 'signed'])
        ->name('verification.verify');
 
Route::post('/email/verification-notification',[AuthController::class, 'resendEmail'])
        ->middleware(['auth:sanctum', 'throttle:6,1'])
        ->name('verification.send');
//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++


Route::post('/login', [AuthController::class, 'loginUser']);
Route::post('/register', [AuthController::class, 'registerUser'])->name('user.add');
Route::post('/add_client', [AuthController::class, 'registerUser']);

//  ROUTE AVEC MIDDLEWARE D'AUTHENTIFICATION ET DE VERIFICATION DE L'ADRESSE MAIL
Route::middleware(['auth:sanctum', 'verified'])->group( function () {
    //+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
    // Routes pour Tout User authentifié  |
    // ___________________________________|
    Route::get('/stores', [ClientController::class, 'getStores']);
    Route::get('/add_client', [ClientController::class, 'addClient']);
    Route::get('/profil', [UserController::class, 'profilUser']);
    Route::post('/update_profil', [UserController::class, 'updateUser']);
    Route::post('/update_image', [UserController::class, 'updateProfilImage']);
    
    //++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
    // ROUTE POUR ADMIN  |
    //___________________|
    Route::middleware('adminAccess')->prefix('admin')->group( function () {
        Route::get('/users', [AdminController::class, 'getUsers']);
        Route::get('/user/{id}', [AdminController::class, 'getUser']);
        Route::get('/stores', [AdminController::class, 'getStores']);
        Route::get('/store/{id}', [AdminController::class, 'getStore']);
        Route::get('/ative_user/{id}', [UserController::class, 'activeUser']);
        Route::get('/active_store/{id}', [StoreController::class, 'activeStore']);
        Route::get('/desactive_store/{id}', [StoreController::class, 'desactiveStore']);
        Route::get('/validate_kyb/{id}', [StoreController::class, 'validateKyb']);
    });

    //++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
    // ROUTE POUR TENANT |
    //___________________|
    Route::middleware('tenantAccess')->prefix('tenant')->group( function () {
        Route::post('/add_store', [StoreController::class, 'addStore'])->withoutMiddleware('tenantAcess');
        Route::post('/update_store/{id}', [StoreController::class, 'updateStore']);
        Route::get('/delete_store/{id}', [StoreController::class, 'deleteStore']);
        Route::get('/active_store/{id}', [StoreController::class, 'activeStore']);
        Route::post('/change_icon/{id}', [StoreController::class, 'changeIcon']);
        
        Route::post('/add_kyb', [KybController::class, 'addKyb']);
        
        Route::post('/add_product', [ProductController::class, 'addProduct']);
        Route::post('/update_product/{id}', [ProductController::class, 'updateProduct']);
        Route::get('/delete_product/{id}', [ProductController::class, 'deleteProduct']);
        Route::get('/active_product/{id}', [ProductController::class, 'activeProduct']);

        Route::get('/product/{id}', [TenantController::class, 'getProduct']);   
        Route::get('/stores', [TenantController::class, 'getStores']);
        Route::get('/store/{id}', [TenantController::class, 'getStore']);
    });
    //+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
    // ROUTE POUR LE CLIENT |
    //______________________|
    Route::middleware(['auth:sanctum', 'clientAccess'])->prefix('client')->group( function () {
        Route::get('/stores', [ClientController::class, 'getStoresClient']);
        Route::get('/shopping_carts', [ClientController::class, 'getShoppingCarts']);
        Route::get('/shopping_cart/{id}', [ClientController::class, 'getShoppingCart']);
        Route::get('/products/{id}', [ProductController::class, 'getProducts_']);
    
        Route::post('/add_shop_cart', [ShoppingCartController::class, 'addShoppingCart']);  
    });
    //++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
});






