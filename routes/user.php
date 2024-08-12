<?php

use Illuminate\Support\Facades\Route;


Route::namespace('User\Auth')->name('user.')->group(function () {

    Route::controller('LoginController')->group(function () {
        Route::get('/login', 'showLoginForm')->name('login');
        Route::post('/login', 'login');
        Route::get('logout', 'logout')->name('logout');
    });

    Route::controller('RegisterController')->group(function () {
        Route::get('register', 'showRegistrationForm')->name('register');
        Route::post('register', 'register')->middleware('regStatus');
        Route::post('check-mail', 'checkUser')->name('checkUser');
    });

    Route::controller('ForgotPasswordController')->group(function () {
        Route::get('password/reset', 'showLinkRequestForm')->name('password.request');
        Route::post('password/email', 'sendResetCodeEmail')->name('password.email');
        Route::get('password/code-verify', 'codeVerify')->name('password.code.verify');
        Route::post('password/verify-code', 'verifyCode')->name('password.verify.code');
    });

    Route::controller('ResetPasswordController')->group(function () {
        Route::post('password/reset', 'reset')->name('password.update');
        Route::get('password/reset/{token}', 'showResetForm')->name('password.reset');
    });
});

Route::name('user.')->group(function () {
    Route::middleware('auth')->group(function () {
        //authorization
        Route::namespace('User')->controller('AuthorizationController')->group(function () {
            Route::get('authorization', 'authorizeForm')->name('authorization');
            Route::get('resend-verify/{type}', 'sendVerifyCode')->name('send.verify.code');
            Route::post('verify-email', 'emailVerification')->name('verify.email');
            Route::post('verify-mobile', 'mobileVerification')->name('verify.mobile');
        });

        Route::middleware(['checkStatus'])->group(function () {

            Route::get('user-data', 'User\UserController@userData')->name('data');
            Route::post('user-data-submit', 'User\UserController@userDataSubmit')->name('data.submit');

            Route::middleware('reg_complete')->namespace('User')->group(function () {

                Route::controller('UserController')->group(function () {
                    Route::get('dashboard', 'home')->name('home');
                    Route::any('payment/history', 'depositHistory')->name('deposit.history');
                    Route::get('transactions', 'transactions')->name('transactions');
                    Route::get('attachment-download/{fil_hash}', 'attachmentDownload')->name('attachment.download');
                });

                Route::controller('BookingController')->group(function () {
                    Route::get('booking-requests', 'bookingRequestList')->name('booking.request.all');
                    Route::post('booking-request/delete/{id}', 'deleteBookingRequest')->name('booking.request.delete');
                    Route::get('bookings/my-bookings', 'allBookings')->name('booking.all');
                    Route::get('booking/payment/{id}', 'payment')->name('booking.payment');
                    Route::get('booking/details/{id}', 'bookingDetails')->name('booking.details');
                });

                //Profile setting
                Route::controller('ProfileController')->group(function () {
                    Route::get('profile-setting', 'profile')->name('profile.setting');
                    Route::post('profile-setting', 'submitProfile');
                    Route::get('change-password', 'changePassword')->name('change.password');
                    Route::post('change-password', 'submitPassword');
                });
            });

            // Payment
            Route::controller('Gateway\PaymentController')->group(function () {
                Route::any('/payment', 'deposit')->name('deposit');
                Route::post('payment/insert', 'depositInsert')->name('deposit.insert');
                Route::get('payment/confirm', 'depositConfirm')->name('deposit.confirm');
                Route::get('payment/manual', 'manualDepositConfirm')->name('deposit.manual.confirm');
                Route::post('payment/manual', 'manualDepositUpdate')->name('deposit.manual.update');
            });
        });
    });
});
