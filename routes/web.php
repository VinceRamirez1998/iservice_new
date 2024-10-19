<?php

use App\User\Model;
use Illuminate\Support\Facades\Route;
use App\Filament\Resources\MyBookingResource;
use App\Http\Controllers\MessagingController;
use App\Http\Controllers\RegistrationController;
use App\Http\Controllers\ServiceBookingController;


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



// Route to display the booking page
Route::get('/service-provider/{id}/book', [ServiceBookingController::class, 'book'])
    ->name('book.service');

// Route to handle the booking confirmation (when the "Book Now" button is clicked)
Route::post('/service-provider/{id}/book-confirm', [ServiceBookingController::class, 'confirmBooking'])
    ->name('service.book.confirm');


Route::get('/my-bookings', MyBookingResource::class . '@index')->name('my_bookings.index');
Route::get('/message/user/{userId}/{bookingId}', [MessagingController::class, 'show'])->name('message.user');
Route::post('/message/user/{userId}/{bookingId}', [MessagingController::class, 'send'])->name('message.send');
