<?php

use App\Http\Controllers\api\BrandController;
use App\Http\Controllers\api\BrandsmodellController;
use App\Http\Controllers\api\BrandvehicleController;
use App\Http\Controllers\api\CategoryController;
use App\Http\Controllers\api\ClientRepositoryController;
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
Route::get('/products', [ProductsController::class, 'index'])->middleware('throttle:60,1');
Route::get('/productsbyname', [ProductsController::class, 'showByName'])->middleware('throttle:60,1');
Route::get('/productsbydescription', [ProductsController::class, 'showByDescription'])->middleware('throttle:60,1');
Route::get('/products/{id}', [ProductsController::class, 'show'])->middleware('throttle:60,1');
Route::get('/productstrend', [ProductsController::class, 'showByTrend'])->middleware('throttle:60,1');
Route::get('/productsmostrequested', [ProductsController::class, 'showByMostRequested'])->middleware('throttle:60,1');

// COMPLEMENTARYPRODUCTS
Route::get('/complementaryproducts', [ComplementaryproductController::class, 'index'])->middleware('throttle:60,1');
Route::get('/complementaryproducts/{id}', [ComplementaryproductController::class, 'getComplementariesByproduct'])->middleware('throttle:60,1');

// BRANDS
Route::get('/brands', [BrandController::class, 'index'])->middleware('throttle:60,1');

// CATEGORIES
Route::get('/categories', [CategoryController::class, 'index'])->middleware('throttle:60,1');

// TYPEVEHICLE
Route::get('/typevehicles', [TypevehicleController::class, 'index'])->middleware('throttle:60,1');

// MODELLS
Route::get('/models', [ModellController::class, 'index'])->middleware('throttle:60,1');
Route::get('/models/brandvehicle/{id}', [ModellController::class, 'getByBrandvehicle'])->middleware('throttle:60,1');

// BRANDVEHICLE
Route::get('/brandvehicles', [BrandvehicleController::class, 'index'])->middleware('throttle:60,1');
Route::get('/brandvehicles/typehicle/{id}', [BrandvehicleController::class, 'showByTypeVehicle'])->middleware('throttle:60,1');

// BRANDSMKODELL
Route::get('/brandsmodell', [BrandsmodellController::class, 'index'])->middleware('throttle:60,1');
Route::get('/brandsmodell/modell/{id}', [BrandsmodellController::class, 'getByModell'])->middleware('throttle:60,1');

// SUBCATEGORY
Route::get('/subcategories', [SubcategoryController::class, 'showAll'])->middleware('throttle:60,1');
Route::get('/subcategories/category/{id}', [SubcategoryController::class, 'showByIdcategory'])->middleware('throttle:60,1');

// PAYMENT
// Route::post('/create-payment', [PaymentController::class, 'createPayment']);
// Route::post('/validate-payment', [PaymentController::class, 'validatePayment']);


// CLIENT
Route::post('/clients', [ClientRepositoryController::class, 'save'])->middleware('throttle:60,1');
Route::get('/clients/export', [ClientRepositoryController::class, 'export'])->middleware('throttle:60,1')->name('clients.export');
