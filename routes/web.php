<?php

use App\Http\Controllers\AdminApartmentController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ApartmentController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\PaymentsController;
use Illuminate\Support\Facades\Auth;
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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');



//  Redirect to apartments index by default
Route::get('/', fn() => redirect()->route('apartments.index'));

//  Apartments Routes
Route::prefix('apartments')->name('apartments.')->group(function () {
    Route::get('/', [ApartmentController::class, 'index'])->name('index');
    Route::get('/all', [ApartmentController::class, 'all_apartment'])->name('all_apartment');
    Route::get('/create', [ApartmentController::class, 'create'])->name('create');
    Route::post('/', [ApartmentController::class, 'store'])->name('store');
    Route::get('/{id}', [ApartmentController::class, 'show'])->name('show');
    Route::get('/{id}/edit', [ApartmentController::class, 'edit'])->name('edit');
    Route::put('/{id}', [ApartmentController::class, 'update'])->name('update');
    Route::delete('/{id}', [ApartmentController::class, 'destroy'])->name('destroy');
});

// Bookings Routes (User)
Route::prefix('bookings')->name('bookings.')->middleware('auth')->group(function () {
    Route::get('/', [BookingController::class, 'index'])->name('index');
    Route::get('/{apartment_id}/create', [BookingController::class, 'create'])->name('create');
    Route::post('/{apartment_id}', [BookingController::class, 'store'])->name('store');
    Route::get('/{booking}', [BookingController::class, 'show'])->name('show');
    Route::delete('/{booking}', [BookingController::class, 'destroy'])->name('destroy');
    Route::post('/{id}/confirm', [BookingController::class, 'confirm'])->name('confirm');
    Route::post('/{id}/cancel', [BookingController::class, 'cancel'])->name('cancel');
    Route::post('/{id}/payment-status', [BookingController::class, 'updatePaymentStatus'])->name('update_payment_status');
});
Route::get('/my-apartments/bookings', [ApartmentController::class, 'myApartmentsWithBookings'])->name('apartments.my_bookings');

Route::middleware(['auth', 'is_admin'])->name('admin.apartments.')->group(function () {
    Route::get('/admin/pending-apartments', [AdminApartmentController::class, 'index'])->name('pending');
    Route::patch('/admin/apartments/{apartment}/approve', [AdminApartmentController::class, 'approve'])->name('approve');
    Route::delete('/admin/apartments/{apartment}', [AdminApartmentController::class, 'destroy'])->name('destroy');
});




// Payments Routes
Route::prefix('payments')->name('payments.')->middleware('auth')->group(function () {
    Route::get('/unpaid', [PaymentsController::class, 'unpaid'])->name('unpaid');
    Route::post('/{booking_id}', [PaymentsController::class, 'pay'])->name('pay');
});
