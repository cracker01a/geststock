<?php
// Route for redirect to login page

use App\Http\Controllers\LoginController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () { return redirect()->route('login.index');});

Route::controller(LoginController::class)->group(function(){
    Route::get('/connexion', 'index')->name('login.index'); // Route for show login page
    Route::get('/verifier/utilisateur/{email}', 'recover_user')->name('recover_user.email'); // Route for show or not the field to confirm password
    Route::post('/connexion', 'login')->name('login'); // Route for login
});
