<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\HomeController;
use App\Http\Controllers\SiteController;


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

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/product', [HomeController::class, 'index2'])->name('product');
Route::get('/edit', [HomeController::class, 'index3'])->name('edit');

Route::get('/site', [HomeController::class, 'index1'])->name('sites');
// Route pour afficher le formulaire d'ajout de site
Route::get('/sites/create', [SiteController::class, 'create'])->name('sites.create');

// Route pour traiter l'envoi du formulaire et ajouter un nouveau site
Route::post('/sites', [SiteController::class, 'store'])->name('sites.store');
Route::post('/sites/{id}/status', [SiteController::class, 'updateStatus']);

Route::resource('sites', SiteController::class);

