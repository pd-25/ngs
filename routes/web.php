<?php

use App\Lib\Router;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SiteController;
use App\Http\Controllers\RoomBookingController;

Route::get('/clear', function () {
    \Illuminate\Support\Facades\Artisan::call('optimize:clear');
});


// User Support Ticket
Route::controller('TicketController')->prefix('ticket')->group(function () {
    Route::get('/', 'supportTicket')->name('ticket');
    Route::get('/new', 'openSupportTicket')->name('ticket.open');
    Route::post('/create', 'storeSupportTicket')->name('ticket.store');
    Route::get('/view/{ticket}', 'viewTicket')->name('ticket.view');
    Route::post('/reply/{ticket}', 'replyTicket')->name('ticket.reply');
    Route::post('/close/{ticket}', 'closeTicket')->name('ticket.close');
    Route::get('/download/{ticket}', 'ticketDownload')->name('ticket.download');
});

Route::get('app/deposit/confirm/{hash}', 'Gateway\PaymentController@appDepositConfirm')->name('deposit.app.confirm');
Route::get('/courses',[SiteController::class,'course'])->name('course'); 
Route::get('/event',[SiteController::class,'event'])->name('event'); 
Route::get('/gallery',[SiteController::class,'gallery'])->name('gallery'); 
Route::get('/single_course/{id}',[SiteController::class,'single_course'])->name('single_course'); 
Route::get('/abouts',[SiteController::class,'abouts'])->name('abouts'); 
Route::get('/about_maritime',[SiteController::class,'about_maritime'])->name('about_maritime'); 

Route::get('/about_maritime',[SiteController::class,'about_maritime'])->name('about_maritime'); 

Route::get('/new_course/{id}',[SiteController::class,'new_course'])->name('new_course'); 


// Route::get('/room_bookings',[RoomBookingController::class,'room_bookings'])->name('room_bookings'); 

// Route::controller('RoomBookingController')->name('room_booking')->prefix('room_booking')->group(function () {
//     Route::get('', 'index')->name('all');
//     // Route::post('{id?}', 'save')->name('save');
//     // Route::post('remove/{id}', 'remove')->name('remove');


// });

Route::controller('RoomBookingController')->name('room_booking.')->prefix('room_booking')->group(function () {
    Route::get('', 'index')->name('all');
    Route::post('save')->name('save');
    // Route::post('remove/{id}', 'remove')->name('remove');
});


Route::controller('SiteController')->group(function () {
    Route::get('/contact', 'contact')->name('contact');
    Route::post('/contact', 'contactSubmit');
    Route::get('/change/{lang?}', 'changeLanguage')->name('lang');

    Route::get('cookie-policy', 'cookiePolicy')->name('cookie.policy');

    Route::get('/cookie/accept', 'cookieAccept')->name('cookie.accept');
    Route::get('room-type-filter', 'filterRoomType')->name('room.type.filter');

    Route::get('updates', 'blog')->name('blog');
    Route::get('full-article/{slug}/{id}', 'blogDetails')->name('blog.details');
    Route::get('book-online', 'roomTypes')->name('room.types');
    Route::get('room-type/{id}/{slug}', 'roomTypeDetails')->name('room.type.details');
    Route::get('room-search', 'checkRoomAvailability')->name('room.available.search');

    Route::get('policy/{slug}/{id}', 'policyPages')->name('policy.pages');

    Route::get('placeholder-image/{size}', 'placeholderImage')->name('placeholder.image');

    Route::post('send-booking-request', 'sendBookingRequest')->name('booking.request');

    Route::get('/{slug}', 'pages')->name('pages');
    Route::get('/', 'index')->name('home');

   
    Route::post('subscribe', 'subscribe')->name('subscribe');
    
    Route::post('/filter_image_bycategory',[SiteController::class,'filter_image_bycategory'])->name('filter_image_bycategory');
   
    

});
