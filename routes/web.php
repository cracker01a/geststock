<?php

use App\Http\Controllers\LoginController;
use App\Http\Controllers\ProductController;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\HomeController;
use App\Http\Controllers\SiteController;
use App\Http\Controllers\Achatcontroller;
use App\Http\Controllers\GroupeAchatController;
use App\Http\Controllers\GroupeVenteController;
use App\Http\Controllers\VenteController;
use App\Http\Controllers\QteController;

use App\Http\Controllers\UserController;


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
    // Route::get('/tableau-de-bord', function () { return view('dashboard'); })->name('dashboard');

    Route::get('/tableau-de-bord' , [VenteController::class , 'log1'])->name('dashboard');
    

    // Routes for site
    Route::resource('site', SiteController::class)->except(['show']);
    Route::controller(SiteController::class)->prefix('site')
                                                 ->name('site.')
                                                ->group(function(){

        Route::get('/enabled/{id}' , 'enabled')->name('enabled');

    });

    // Routes for product
    Route::resource('product', ProductController::class)->except(['show']);
    Route::controller(ProductController::class)->prefix('product')
                                                ->name('product.')
                                                ->group(function(){

        Route::get('/liste/{sites_id?}', 'getData')->name('get_data');
        Route::get('/enabled/{id}' , 'enabled')->name('enabled');
        Route::get('/product/{id}/price' , 'getPrice')->name('price');
        Route::get('/products/{id}/quantity' , 'getQuantity')->name('quantity');

    });

    // Route for groupe achat


    // Routes for achat
    // Resource routes for 'achat' excluding the 'show' method
    Route::resource('achat', AchatController::class)->except(['show']);
    Route::controller(AchatController::class)->prefix('achat')
                                                ->name('achat.')
                                                ->group(function () {

        Route::get('/enabled/{id}', 'enabled')->name('enabled');
        Route::delete('/delete/{id}', 'destroy')->name('delete');
        Route::get('/achat/liste/{sites_id?}', 'getData')->name('get_data');
        Route::delete('/groupe/delete/{id}', 'destroy')->name('groupe.delete');
        Route::resource('groupe', GroupeAchatController::class)->except(['show']);

    });

    // Routes for 'ventes'
    Route::resource('ventes', VenteController::class)->except(['show']);
    Route::get('/index1', [VenteController::class, 'index1'])->name('ventes.index1');
    Route::get('/inventaires', [VenteController::class, 'index2'])->name('ventes.index2');
    route::get('/get-numero-achat/{productId}', [VenteController::class, 'getNumeroAchat']);

    Route::get('/inventaires/index2', [VenteController::class, 'index2'])->name('inventaires.index2');

    // Routes for 'groupe_ventes'ventes.get_data

    // Route::delete('/groupe_ventes/delete/{id}', [GroupeVenteController::class, 'destroy'])->name('groupe_ventes.delete');

    Route::controller(VenteController::class)->prefix('ventes')
        ->name('ventes.')
        ->group(function () {

        Route::get('/{vente}/edit', 'edit')->name('edit');
        Route::get('/achat/liste/{sites_id?}', 'getData')->name('get_data');
        Route::put('/{vente}', 'updateCustom')->name('updateCustom');
        Route::get('/enabled/{id}', 'enabled')->name('enabled');
        Route::delete('/delete/{id}', 'destroy')->name('delete');
        Route::resource('groupe_ventes', GroupeVenteController::class)->except(['show']);

    });

    // Routes for users
    Route::controller(UserController::class)->prefix('users')
        ->name('users.')
        ->group(function () {

        Route::get('/create', 'create')->name('create');
        Route::post('/', 'store')->name('store');
        Route::get('/', 'index')->name('index');
        Route::get('/{id}/edit', 'edit')->name('edit');
        Route::put('/{id}', 'update')->name('update');
        Route::delete('/{id}', 'destroy')->name('destroy');

    });

});




