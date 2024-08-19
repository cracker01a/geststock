<?php

use App\Http\Controllers\LoginController;
use App\Http\Controllers\ProductController;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\HomeController;
use App\Http\Controllers\SiteController;
use App\Http\Controllers\Achatcontroller;
use App\Http\Controllers\GroupeAchatController;
use App\Http\Controllers\VenteController;

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
    Route::get('/tableau-de-bord', function () { return view('dashboard'); })->name('dashboard');

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


        Route::resource('groupe', GroupeAchatController::class)->except(['show']);
        Route::delete('/groupe/delete/{id}', 'destroy')->name('groupe.delete');
    });

    // Routes for 'ventes'
    Route::resource('ventes', VenteController::class)->except(['show']);
    Route::get('/products/{id}/quantity', [ProductController::class , 'getQuantity'])->name('products.quantity');

    Route::controller(VenteController::class)->prefix('ventes')
        ->name('ventes.')
        ->group(function () {
            Route::get('/{vente}/edit', 'edit')->name('edit');
            Route::put('/{vente}', 'update')->name('update');
            Route::get('/enabled/{id}', 'enabled')->name('enabled');
            Route::delete('/delete/{id}', 'destroy')->name('delete');
        });

    // Route for getting the price of a product
    Route::get('/products/{id}/price', function($id) {
        $product = App\Models\Product::find($id);
        return response()->json(['price' => $product->price]);
    })->name('products.price');

});



// Routes for users
Route::get('users/create', [UserController::class, 'create'])->name('users.create');
Route::post('users', [UserController::class, 'store'])->name('users.store');
Route::get('users', [UserController::class, 'index'])->name('users.index');

Route::get('users/{id}/edit', [UserController::class, 'edit'])->name('users.edit');
Route::put('users/{id}', [UserController::class, 'update'])->name('users.update');
Route::delete('users/{id}', [UserController::class, 'destroy'])->name('users.destroy');
