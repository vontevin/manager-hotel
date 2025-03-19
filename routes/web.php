<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Session;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\RoomController;
use App\Http\Controllers\AboutController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\StaffController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\AmenityController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\RoomTypeController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\Auth\GoogleController;

use App\Http\Controllers\NewbookingsController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\PaymentMomneyController;
use App\Http\Controllers\RecordBookingController;
use App\Http\Controllers\Webfront\FrontController;
use App\Http\Controllers\Webfront\PackagesController;
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
// Route::get('/tes', function () {
//     return view('auth.cus_login');
// });

Route::get('web/', [FrontController::class, 'index']);

// Route::get('/', function () {
//     return view('web_frontend.master_web.fornt_master');
// });

Route::post('/logout', function () {
    Auth::logout();
    return redirect('/');
})->name('logout');

// Route::group(['middleware' => ['isAdmin']], function() {

//======== ./ Permission ===========//
Route::resource('permissions', App\Http\Controllers\PermissionController::class);

//======== ./ Role ===========//
Route::resource('roles', App\Http\Controllers\RoleController::class);

Route::get('permissions/{permissionId}/delete', [App\Http\Controllers\PermissionController::class, 'destroy']);
Route::get('roles/{roleId}/delete', [App\Http\Controllers\RoleController::class, 'destroy']);

//======== ./ Role give-permission ===========//
Route::get('roles/{roleId}/give-permissions', [App\Http\Controllers\RoleController::class, 'addPermissionToRole']);
Route::put('roles/{roleId}/give-permissions', [App\Http\Controllers\RoleController::class, 'givePermissionToRole']);

//======== ./ User ===========//
Route::resource('users', App\Http\Controllers\UserController::class);
Route::get('users/{userId}/delete', [App\Http\Controllers\UserController::class, 'destroy']);
Route::get('change-password/{id}', [App\Http\Controllers\UserController::class, 'showChangePasswordForm'])->name('change-password');
Route::put('change-password/{id}', [App\Http\Controllers\UserController::class, 'changePassword'])->name('update-password');
Route::get('profile', [App\Http\Controllers\UserController::class, 'profile'])->name('profile');
Route::post('profile/update', [App\Http\Controllers\UserController::class, 'updateProfile'])->name('profile.update');




//======== ./ Rooms ===========//
Route::get('rooms', [App\Http\Controllers\RoomController::class, 'index']);
Route::get('rooms/create', [App\Http\Controllers\RoomController::class, 'create']);
Route::post('/rooms', [RoomController::class, 'store'])->name('rooms.store');
Route::get('rooms/show/{id}',[App\Http\Controllers\RoomController::class,'show'])->name('admin.rooms.show');
Route::get('rooms/{id}/edit', [App\Http\Controllers\RoomController::class, 'edit']);
Route::put('rooms/{id}', [App\Http\Controllers\RoomController::class, 'update'])->name('admin.rooms.update');
Route::get('rooms/{id}/delete', [App\Http\Controllers\RoomController::class, 'destroy']);
Route::get('/viewroom/{id}', [RoomController::class, 'show'])->name('viewroom');
// Bookings
Route::resource('bookings', BookingController::class);

// Custom routes for bookings
Route::get('/bookings/{booking}/check-in', [BookingController::class, 'checkIn'])->name('bookings.check-in');
Route::post('/bookings/{booking}/check-in', [BookingController::class, 'processCheckIn'])->name('bookings.process-check-in');
Route::get('/bookings/{booking}/check-out', [BookingController::class, 'checkOut'])->name('bookings.check-out');
Route::post('/bookings/{booking}/check-out', [BookingController::class, 'processCheckOut'])->name('bookings.process-check-out');
Route::post('/bookings/{booking}/cancel', [BookingController::class, 'cancel'])->name('bookings.cancel');
Route::get('/bookings/period', [BookingController::class, 'period'])->name('bookings.period');

//============== Check In/Out =================//
Route::get('/check-in-out', [App\Http\Controllers\CheckInOutController::class, 'index'])->name('check-in-out.index');
Route::get('/check-in-out/today', [App\Http\Controllers\CheckInOutController::class, 'today'])->name('check-in-out.today');

//======== ./ RoomsType ===========//
Route::get('/roomtypes', [RoomTypeController::class, 'index'])->name('roomtypes.index');
Route::get('roomtypes/create', [RoomTypeController::class, 'create'])->name('admin.roomtypes.create');
Route::post('roomtypes', [RoomTypeController::class, 'store'])->name('admin.roomtypes.store');
Route::get('/roomtypes/show/{roomType}', [RoomTypeController::class, 'show'])->name('roomtypes.show');
Route::get('roomtypes/{id}/edit', [RoomTypeController::class, 'edit'])->name('admin.roomtypes.edit');
Route::put('roomtypes/{id}', [RoomTypeController::class, 'update'])->name('admin.roomtypes.update');

Route::get('roomtypes/{id}/delete', [RoomTypeController::class, 'destroy'])->name('admin.roomtypes.delete');


//======== ./ Dashboard ===========//
Route::get('/dashboard', 'DashboardController@index')->middleware('auth');

//======== ./ Booking Rooms ===========//
Route::resource('bookings', BookingController::class);
Route::get('bookings/{booking}/edit', [BookingController::class, 'edit'])->name('bookings.edit');
Route::put('bookings/{booking}', [BookingController::class, 'update'])->name('bookings.update');
Route::get('/bookings/{booking}/check-in', [BookingController::class, 'checkIn'])->name('bookings.check-in');
Route::post('/bookings/{booking}/check-in', [BookingController::class, 'processCheckIn'])->name('bookings.process-check-in');
Route::get('/bookings/{booking}/check-out', [BookingController::class, 'checkOut'])->name('bookings.check-out');
Route::post('/bookings/{booking}/check-out', [BookingController::class, 'processCheckOut'])->name('bookings.process-check-out');

Route::get('/bookings-export', [BookingController::class, 'export'])->name('bookings.export');

Route::get('/bookings/{id}/delete', [BookingController::class, 'destroy'])->name('bookings.destroy'); 
Route::get('/bookings/{booking}/cancel', [BookingController::class, 'cancel'])->name('bookings.cancel');
Route::get('/bookings/{id}/confirm', [BookingController::class, 'confirm'])->name('bookings.confirm');

//=========== ./ New Bookings ===========//
Route::get('/newbookings', [NewbookingsController::class, 'index'])->name('newbookings.index');
//========= ./ Controller Front End Website =============//
Route::get('/', [FrontController::class, 'index']);
Route::get('home', [App\Http\Controllers\Webfront\FrontController::class, 'index'])->name('home');
Route::get('room', [App\Http\Controllers\Webfront\RoomPicController::class, 'index'])->name('room');

// Route for searching rooms
Route::get('search-rooms', [App\Http\Controllers\Webfront\RoomPicController::class, 'search'])->name('search.rooms');

Route::get('/viewroom/{id}', [App\Http\Controllers\Webfront\ViewRoomController::class, 'index'])->name('viewrooms.index');
Route::post('/viewrooms', [App\Http\Controllers\Webfront\ViewRoomController::class, 'store'])->name('viewrooms.store');

// Change the route path or name to avoid conflict
Route::get('/payment/viewroom/{id}', [PaymentController::class, 'showRoom'])->name('payment.viewroom');

Route::get('contact', [App\Http\Controllers\ContactControllerController::class, 'index'])->name('contact');
Route::get('about', [AboutController::class, 'index'])->name('about');
Route::get('service', [ServiceController::class, 'index'])->name('service');


// =============== Payments Controller ===================//
Route::resource('payments', PaymentController::class);
Route::post('/payments/{booking}/add', [PaymentController::class, 'addPayment'])->name('payments.add');
Route::get('/payments/{payment}/receipt', [PaymentController::class, 'receipt'])->name('payments.receipt');
Route::get('/payments-export', [PaymentController::class, 'export'])->name('payments.export');
Route::get('/payments/{id}/delete', [PaymentController::class, 'destroy'])->name('payments.destroy');
Route::get('/room/{id}', [PaymentController::class, 'showRoom'])->name('room.show');
Route::get('payments/{booking}/edit', [PaymentController::class, 'edit'])->name('payments.edit');
Route::put('payments/{booking}', [PaymentController::class, 'update'])->name('payments.update');


// =============== Invoce Controller ===================//
Route::get('invoice/{id}', [InvoiceController::class, 'index'])->name('invoices.index');
Route::get('payment-list/{id}', [InvoiceController::class, 'cardList'])->name('payment-list');
Route::get('payment/{id}', [InvoiceController::class, 'payWithCard'])->name('payment');
Route::post('/update-booking-record', [InvoiceController::class, 'updateBookingRecord'])->name('updateBookingRecord');
Route::get('/delete-payment/{id}', [InvoiceController::class, 'deletePayment'])->name('deletePayment');

// =============== Bookig System Event Calendar Controller ===================//

Route::resource('events', EventController::class);
Route::post('/event-calendar', [EventController::class, 'store'])->name('event_calendar.store');
Route::delete('/event_calendar/destroy/{id}', [EventController::class, 'destroy'])->name('event_calendar.destroy');
Route::post('/check-availability', [EventController::class, 'checkAvailability']);

Auth::routes();Route::patch('/event_calendar/update/{id}', [EventController::class, 'update'])->name('event_calendar.update');

//======== ./ Admin Dashboard ===========//

Route::get('/dashbord', [App\Http\Controllers\HomeController::class, 'index'])->name('dashbord');
Route::get('/get-reservation-statistics',[App\Http\Controllers\HomeController::class, 'getReservationStatistics']);
Route::get('/get-check-in-out-data',[App\Http\Controllers\HomeController::class, 'getCheckInOutData']);
Route::get('/admin/bookings/daily-count', [App\Http\Controllers\HomeController::class, 'dailyBookingsCount'])->name('daily.bookings');
// Add this to your routes file
Route::get('/getCheckInOutData',  [App\Http\Controllers\HomeController::class, 'getCheckInOutData']);

//========== for switching language route =============//

Route::get('/lang/{locale}', function ($locale) {
    Session::put('locale', $locale);
    
    // Set the default currency based on the selected language
    if ($locale == 'kh') {
        Session::put('currency', 'KHR'); // Khmer Riel
    } else {
        Session::put('currency', 'USD'); // US Dollars
    }

    return redirect()->back();
});



Route::get('/notifications', [NotificationController::class, 'getNotifications']);
Route::get('/booking/guest-name/{id}', [BookingController::class, 'getGuestName']);

//============ Ouy Guest Say =============// 

// Routes for Guest
Route::resource('clients', App\Http\Controllers\Webfront\ClientController::class);
Route::get('clients/{id}/delete', [App\Http\Controllers\Webfront\ClientController::class, 'destroy']);

// Routes for Gallery Page
Route::resource('galleries', App\Http\Controllers\Webfront\GalleryController::class); // Use proper namespace for consistency

// Specific gallery routes for the frontend
Route::get('galleries/{id}', [App\Http\Controllers\Webfront\GalleryController::class, 'show'])->name('galleries.show');
Route::get('galleries/{id}/delete', [App\Http\Controllers\Webfront\GalleryController::class, 'destroy']); // delete action
Route::get('galleries/{id}/edit', [App\Http\Controllers\Webfront\GalleryController::class, 'edit'])->name('galleries.edit'); // edit action
Route::put('galleries/{id}', [App\Http\Controllers\Webfront\GalleryController::class, 'update'])->name('galleries.update'); // update gallery action

Route::resource('packages', PackagesController::class); // Define the resource routes
Route::get('/packages/{id}', [PackagesController::class, 'show'])->name('packages.show');

Route::get('packages/{id}/delete', [PackagesController::class, 'destroy'])->name('packages.destroy'); // Custom delete route

//========== Routing Google Controller =============//

Route::get('/auth/google', [GoogleController::class, 'redirectGoogle'])->name('auth.google');
Route::get('/auth/google/callback', [GoogleController::class, 'googleCallback']); // Use 'googleCallback' to match the method name


Route::get('/get-reservation-statistics', [HomeController::class, 'getReservationStatistics']);
Route::get('/bookings', [BookingController::class, 'period'])->name('booking.index');

Route::post('/booking_record/store', [EventController::class, 'store'])->name('booking_record.store');
Route::post('/booking_record/update/{id}', [EventController::class, 'update'])->name('booking_record.update');
Route::delete('/booking_record/destroy/{id}', [EventController::class, 'destroy'])->name('booking_record.destroy'); 


// Report Routes
Route::get('/reports', [ReportController::class, 'index'])->name('reports.index');
Route::get('/reports/create', [ReportController::class, 'create'])->name('reports.create');
Route::post('/reports', [ReportController::class, 'store'])->name('reports.store');
Route::get('/reports/{id}', [ReportController::class, 'show'])->name('reports.show');
Route::get('/reports/{id}/edit', [ReportController::class, 'edit'])->name('reports.edit');
Route::put('/reports/{id}', [ReportController::class, 'update'])->name('reports.update');
Route::delete('/reports/{id}', [ReportController::class, 'destroy'])->name('reports.destroy');


// Customers Routes
Route::get('/customers/{id}/delete', [CustomerController::class, 'destroy'])->name('customers.destroy'); 
Route::resource('customers', CustomerController::class);


Route::resource('staffs', StaffController::class); 
Route::get('staffs/{id}/delete', [StaffController::class, 'destroy'])->name('staffs.delete');

Route::resource('amenities', AmenityController::class);
Route::get('amenities/{id}/delete', [AmenityController::class, 'destroy'])->name('amenities.delete');