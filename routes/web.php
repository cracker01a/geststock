<?php

use App\Http\Controllers\LoginController;
use App\Http\Controllers\ProductController;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\HomeController;
use App\Http\Controllers\SiteController;
use App\Http\Controllers\achatcontroller;


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

    // Route for logout
    Route::get('/deconnexion' , [LoginController::class , 'logout'])->name('logout');

    // Affichage du dashboard
    Route::get('/tableau-de-bord', function () { return view('dashboard'); })->name('dashboard');

    // Routes for product
    Route::resource('product', ProductController::class)->except(['show']);
    Route::controller(ProductController::class)->prefix('product')
                                                ->name('product.')
                                                ->group(function(){
        Route::get('/enabled/{id}' , 'enabled')->name('enabled');
    });

    // Routes for site
    Route::resource('site', SiteController::class)->except(['show']);
    Route::controller(SiteController::class)->prefix('site')
                                                 ->name('site.')
                                                ->group(function(){
        Route::get('/enabled/{id}' , 'enabled')->name('enabled');
    });


     // Routes for achat
  // Resource routes for 'achat' excluding the 'show' method
  Route::resource('achat', AchatController::class)->except(['show']);

  Route::controller(AchatController::class)->prefix('achat')
                                            ->name('achat.')
                                            ->group(function () {
      Route::get('/enabled/{id}', 'enabled')->name('enabled');
      Route::delete('/delete/{id}', 'destroy')->name('delete');
  });

});



