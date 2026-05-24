<?php

use App\Http\Controllers\api\BrandController;
use App\Http\Controllers\api\BrandsmodellController;
use App\Http\Controllers\api\BrandvehicleController;
use App\Http\Controllers\api\CategoryController;
use App\Http\Controllers\api\ComplementaryproductController;
use App\Http\Controllers\api\ModellController;
use App\Http\Controllers\api\PaymentController;
use App\Http\Controllers\api\ProductsController;
use App\Http\Controllers\api\SubcategoryController;
use App\Http\Controllers\api\TypevehicleController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');


// PRODUCTS
Route::get('/products', [ProductsController::class, 'index']);
Route::get('/products/all', [ProductsController::class, 'showAll']);
Route::get('/productsbyname', [ProductsController::class, 'showByName']);
Route::get('/productsbydescription', [ProductsController::class, 'showByDescription']);
Route::get('/products/{id}', [ProductsController::class, 'show']);
Route::get('/productstrend', [ProductsController::class, 'showByTrend']);
Route::get('/productsmostrequested', [ProductsController::class, 'showByMostRequested']);

// COMPLEMENTARYPRODUCTS
Route::get('/complementaryproducts', [ComplementaryproductController::class, 'index']);
Route::get('/complementaryproducts/{id}', [ComplementaryproductController::class, 'getComplementariesByproduct']);

// BRANDS
Route::get('/brands', [BrandController::class, 'index']);

// CATEGORIES
Route::get('/categories', [CategoryController::class, 'index']);

// TYPEVEHICLE
Route::get('/typevehicles', [TypevehicleController::class, 'index']);

// MODELLS
Route::get('/models', [ModellController::class, 'index']);
Route::get('/models/brandvehicle/{id}', [ModellController::class, 'getByBrandvehicle']);

// BRANDVEHICLE
Route::get('/brandvehicles', [BrandvehicleController::class, 'index']);
Route::get('/brandvehicles/typehicle/{id}', [BrandvehicleController::class, 'showByTypeVehicle']);


// BRANDSMKODELL
Route::get('/brandsmodell', [BrandsmodellController::class, 'index']);
Route::get('/brandsmodell/modell/{id}', [BrandsmodellController::class, 'getByModell']);


// SUBCATEGORY
Route::get('/subcategories', [SubcategoryController::class, 'showAll']);
Route::get('/subcategories/category/{id}', [SubcategoryController::class, 'showByIdcategory']);


// PAYMENT
Route::post('/create-payment', [PaymentController::class, 'createPayment']);
Route::post('/validate-payment', [PaymentController::class, 'validatePayment']);
