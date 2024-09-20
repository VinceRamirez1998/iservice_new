<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RegistrationController;
use App\User\Model;

/*
|----------------------------------------------------------------------
| Web Routes
|----------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('auth.register'); 

});

// Register and Pending Page
Route::get('/register', [App\Http\Controllers\RegistrationController::class, 'showRegistrationForm'])->name('register.form');
Route::post('/register', [App\Http\Controllers\RegistrationController::class, 'register'])->name('register.post');
Route::get('/auth/pending', [RegistrationController::class, 'pending'])->name('auth.pending');


// HEADER
Route::view('/contact', 'contact')->name('contact');
Route::view('/faq', 'faq')->name('faq');
Route::view('/about', 'about')->name('about');
