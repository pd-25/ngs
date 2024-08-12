<?php

use Illuminate\Support\Facades\Route;


Route::namespace('Auth')->controller('LoginController')->group(function () {
    Route::get('/', 'showLoginForm')->name('login');
    Route::post('/', 'login')->name('login');
    Route::get('logout', 'logout')->name('logout');

    Route::controller('ForgotPasswordController')->group(function () {
        Route::get('password/reset', 'showLinkRequestForm')->name('password.reset');
        Route::post('password/reset', 'sendResetCodeEmail');
        Route::get('password/code-verify', 'codeVerify')->name('password.code.verify');
        Route::post('password/verify-code', 'verifyCode')->name('password.verify.code');
    });

    Route::controller('ResetPasswordController')->group(function () {
        Route::get('password/reset/{token}', 'showResetForm')->name('password.reset.form');
        Route::post('password/reset/change', 'reset')->name('password.change');
    });
});

Route::controller('ExpanceManagmentController')->name('expense_managment.')->prefix('expense_managment')->group(function () {
    Route::get('', 'index')->name('all');
    // Route::post('{id?}', 'save')->name('save');
    Route::get('report', 'report')->name('report');
    
    Route::post('remove/{id}', 'remove')->name('remove');


});

Route::controller('ExpanceManagmentController')->name('expance_report.')->prefix('expance_report')->group(function () {
   Route::get('report', 'report')->name('report');
    Route::post('filter_by_user', 'filter_by_user')->name('filter_by_user');
    Route::post('filter_by_date', 'filter_by_date')->name('filter_by_date');
    // Route::post('{id?}', 'save')->name('save');
    Route::post('remove/{id}', 'remove')->name('remove');


});

Route::post('expense_managment/{id?}', 'ExpanceManagmentController@store')->name('expense_managment.store');

Route::middleware('receptionist')->group(function () {
    Route::controller('ReceptionistController')->group(function () {

        Route::get('profile', 'profile')->name('profile');
        Route::post('profile', 'profileUpdate')->name('profile.update');
        Route::get('password', 'password')->name('password');
        Route::post('password', 'passwordUpdate')->name('password.update');
    });

    Route::controller('ManageBookingRequestController')->group(function () {
        Route::get('booking-requests', 'index')->name('booking.request.all');
        Route::get('booking-request-approve/{id}', 'approve')->name('booking.request.approve');
        Route::post('booking-request-cancel/{id}', 'cancel')->name('booking.request.cancel');
        Route::post('assign-room', 'assignRoom')->name('assign.room');
    });

    Route::controller('BookingController')->group(function () {
        Route::get('dashboard', 'todaysBooked')->name('dashboard');
        Route::get('book-room', 'room')->name('book.room');
        Route::post('room-book', 'book')->name('room.book');
        Route::get('room/search', 'searchRoom')->name('room.search');
        Route::get('mobile', 'mobile')->name('get.mobile');

        Route::name('booking.')->prefix('booking')->group(function () {
            Route::get('all-bookings', 'allBookingList')->name('all');
             Route::post('filter_status', 'inactiveActiveStatus')->name('filter_status');

            Route::get('approved', 'activeBookings')->name('active');
            Route::post('booking/cancel/{bookingId?}', 'cancelBooking')->name('cancel');

            Route::get('booking-cancel-requests', 'bookingCancelRequestList')->name('cancel.request.list');
            Route::get('checked-out-booking', 'checkedOutBookingList')->name('checked_out.list');

            Route::get('cancelled-bookings', 'cancelledBookingList')->name('cancelled.list');

            Route::post('booking-merge/{id}', 'mergeBooking')->name('merge');

            Route::get('booking-checkout/{id}', 'checkOutPreview')->name('checkout');
            Route::post('booking/payment/partial/{id}', 'payment')->name('payment.partial');
            Route::post('booking-checkout/{id}', 'checkOut')->name('checkout');

            Route::get('booking-invoice/{bookingId}', 'generateInvoice')->name('invoice');

            Route::get('booking/details/{bookingId}', 'bookingDetails')->name('details');
            Route::get('booking/extra-service/details/{bookingId}', 'extraServiceDetail')->name('service.details');
        });

        Route::post('booked-room/cancel/{roomId}', 'cancelBookedRoom')->name('booked.room.cancel');
        Route::post('cancel-booking/{id}/{day}', 'cancelBookingByDate')->name('booked.day.cancel');
    });

    Route::controller('ExtraServiceController')->name('extra.service.')->group(function () {
        Route::get('extra-service/added-by-me', 'list')->name('list');
        Route::get('extra-service/add-new', 'addNew')->name('add');
        Route::post('add-extra-service', 'addService')->name('save');
        Route::post('extra-service/delete/{id}', 'delete')->name('delete');
    });

    // PAYMENT SYSTEM
    Route::name('deposit.')->controller('DepositController')->prefix('payment')->group(function () {
        Route::get('/', 'deposit')->name('list');
        Route::get('pending', 'pending')->name('pending');
        Route::get('details/{id}', 'details')->name('details');

        Route::post('reject', 'reject')->name('reject');
        Route::post('approve/{id}', 'approve')->name('approve');
    });
});
