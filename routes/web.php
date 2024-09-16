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
Route::get('/register', [App\Http\Controllers\RegistrationController::class, 'showRegistrationForm'])->name('register.form');

Route::post('/register', [App\Http\Controllers\RegistrationController::class, 'register'])->name('register.post');

