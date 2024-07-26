<?php

use App\Http\Controllers\LoginController;
use App\Http\Controllers\ProductController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

require_once 'auth.php';

// Routes after login
Route::group(['middleware' => ['auth']] , function(){

    Route::get('/tableau-de-bord', function () {
        return view('layouts.dash');
    });

    // Routes for product
    Route::resource('product', ProductController::class)->except(['show']);
    Route::get('/enabled/{id}' , [ProductController::class , 'enabled'])->name('product.enabled');

    // Route for logout
    Route::get('/deconnexion' , [LoginController::class , 'logout'])->name('logout');

});
