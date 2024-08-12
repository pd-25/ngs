<?php

use Illuminate\Support\Facades\Route;
Route::get('/available-rooms', [ExpanceManagmentController::class, 'availableRooms'])->name('available-rooms');

Route::controller('CourseController')->name('course.')->prefix('course')->group(function () {
    Route::get('', 'index')->name('all');
    // Route::post('{id?}', 'save')->name('save');
    Route::post('remove/{id}', 'remove')->name('remove');

});
Route::controller('EventController')->name('event.')->prefix('event')->group(function () {
    Route::get('', 'index')->name('all');
    Route::post('{id?}', 'save')->name('save');
    Route::post('remove/{id}', 'remove')->name('remove');


});
Route::controller('ReceiptController')->name('receipt.')->prefix('receipt')->group(function () {
    Route::get('', 'index')->name('all');
    Route::post('{id?}', 'save')->name('save');
    Route::post('remove/{id}', 'remove')->name('remove');


});


Route::controller('PendingPaymentController')->name('pendings.')->prefix('pendings')->group(function () {
    Route::get('', 'index')->name('all');
    Route::post('{id?}', 'save')->name('save');
    Route::post('remove/{id}', 'remove')->name('remove');


});


Route::controller('ExpanceController')->name('expense.')->prefix('expense')->group(function () {
    Route::get('', 'index')->name('all');
    // Route::post('{id?}', 'save')->name('save');
    Route::post('remove/{id}', 'remove')->name('remove');


});
Route::controller('ExpanceManagmentController')->name('expense_managment.')->prefix('expense_managment')->group(function () {
    Route::get('', 'index')->name('all');
    // Route::post('{id?}', 'save')->name('save');
    Route::post('remove/{id}', 'remove')->name('remove');


});
Route::controller('ExpanceManagmentController')->name('booking_availability.')->prefix('booking_availability')->group(function () {
    Route::get('', 'view')->name('all');
    // Route::post('{id?}', 'save')->name('save');
    // Route::post('remove/{id}', 'remove')->name('remove');


});


Route::controller('ExpanceReportController')->name('expance_report.')->prefix('expance_report')->group(function () {
    Route::get('', 'index')->name('all');
    Route::post('filter_by_user', 'filter_by_user')->name('filter_by_user');
    Route::post('filter_by_date', 'filter_by_date')->name('filter_by_date');
    Route::post('filter_by_customer', 'filter_by_customer')->name('filter_by_customer');
    // Route::post('{id?}', 'save')->name('save');
    Route::post('remove/{id}', 'remove')->name('remove');


});

Route::get('/guest-details', [ExpanceReportController::class, 'showGuestDetails'])->name('guest-details');

Route::post('expense/{id?}', 'ExpanceController@store')->name('expense.store');
Route::post('expense_managment/{id?}', 'ExpanceManagmentController@store')->name('expense_managment.store');

Route::post('gallery/{id?}', 'GalleryController@store')->name('gallery.store');

Route::post('event/{id?}', 'EventController@store')->name('event.store');

Route::post('course/{id?}', 'CourseController@store')->name('course.store');

Route::controller('GalleryController')->name('gallery.')->prefix('gallery')->group(function () {
    Route::get('', 'index')->name('all');
    // Route::post('{id?}', 'save')->name('save');
    Route::post('remove/{id}', 'remove')->name('remove');


});
Route::controller('GalleryCategoryController')->name('gallery_category.')->prefix('gallery_category')->group(function () {
    Route::get('', 'index')->name('all');
    Route::post('{id?}', 'save')->name('save');
    Route::post('remove/{id}', 'remove')->name('remove');


});



Route::namespace('Auth')->controller('LoginController')->group(function () {
    Route::get('/', 'showLoginForm')->name('login');
    Route::post('/', 'login')->name('login');
    Route::get('logout', 'logout')->name('logout');

    // Admin Password Reset
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

Route::middleware('admin')->group(function () {

    Route::controller('AdminController')->group(function () {
        Route::get('dashboard', 'dashboard')->name('dashboard');
        Route::get('profile', 'profile')->name('profile');
        Route::post('profile', 'profileUpdate')->name('profile.update');
        Route::get('password', 'password')->name('password');
        Route::post('password', 'passwordUpdate')->name('password.update');


        //Notification
        Route::get('notifications', 'notifications')->name('notifications');
        Route::get('notification/read/{id}', 'notificationRead')->name('notification.read');
        Route::get('notifications/read-all', 'readAll')->name('notifications.readAll');

        //Report Bugs
        Route::get('request-report', 'requestReport')->name('request.report');
        Route::post('request-report', 'reportSubmit');

        Route::get('download-attachments/{file_hash}', 'downloadAttachment')->name('download.attachment');
    });

    Route::controller('ReceptionistController')->name('receptionist.')->prefix('receptionist')->group(function () {
        Route::get('', 'index')->name('all');
        Route::post('{id?}', 'save')->name('save');
        Route::get('login/{id}', 'login')->name('login');
    });


    // Users Manager
    Route::controller('ManageUsersController')->name('users.')->prefix('users')->group(function () {
        Route::get('users', 'allUsers')->name('all');
        Route::get('active', 'activeUsers')->name('active');
        Route::get('banned', 'bannedUsers')->name('banned');
        Route::get('email-verified', 'emailVerifiedUsers')->name('email.verified');
        Route::get('email-unverified', 'emailUnverifiedUsers')->name('email.unverified');
        Route::get('mobile-unverified', 'mobileUnverifiedUsers')->name('mobile.unverified');
        Route::get('mobile-verified', 'mobileVerifiedUsers')->name('mobile.verified');
        Route::get('mobile-verified', 'mobileVerifiedUsers')->name('mobile.verified');

        Route::get('detail/{id}', 'detail')->name('detail');
        Route::post('update/{id}', 'update')->name('update');
        Route::post('add-sub-balance/{id}', 'addSubBalance')->name('add.sub.balance');
        Route::get('send-notification/{id}', 'showNotificationSingleForm')->name('notification.single');
        Route::post('send-notification/{id}', 'sendNotificationSingle')->name('notification.single');
        Route::get('login/{id}', 'login')->name('login');
        Route::post('status/{id}', 'status')->name('status');

        Route::get('send-notification', 'showNotificationAllForm')->name('notification.all');
        Route::post('send-notification', 'sendNotificationAll')->name('notification.all.send');
        Route::get('notification-log/{id}', 'notificationLog')->name('notification.log');
        
        Route::get('cdc', 'cdc')->name('get.cdc');
        

    });

    Route::name('hotel.')->prefix('hotel')->group(function () {
        Route::controller('AmenitiesController')->name('amenity.')->prefix('amenities')->group(function () {
            Route::get('', 'index')->name('all');
            Route::post('save/{id?}', 'save')->name('save');
        });
        //Bed Type
        Route::controller('BedTypeController')->name('bed.')->prefix('bed-list')->group(function () {
            Route::get('', 'index')->name('all');
            Route::post('save/{id?}', 'save')->name('save');
            Route::post('delete/{id}', 'delete')->name('delete');
        });

        //Complement
        Route::controller('ComplementController')->name('complement.')->prefix('complements')->group(function () {
            Route::get('', 'index')->name('all');
            Route::post('save/{id?}', 'save')->name('save');
        });

        //Room Type
        Route::controller('RoomTypeController')->name('room.type.')->prefix('room-type')->group(function () {
            Route::get('', 'index')->name('all');
            Route::get('create', 'create')->name('create');
            Route::get('edit/{id}', 'edit')->name('edit');
            Route::post('save/{id?}', 'save')->name('save');
            Route::post('status/{id}', 'status')->name('status');
        });

        //Room
        Route::controller('RoomController')->name('room.')->prefix('room')->group(function () {
            Route::get('', 'index')->name('all');
            Route::post('update/status/{id}', 'status')->name('status');
        });

        //Extra Services
        Route::controller('ExtraServiceController')->name('extra_services.')->prefix('extra-service')->group(function () {
            Route::get('', 'index')->name('all');
            Route::post('save/{id?}', 'save')->name('save');
            Route::post('update/{id}', 'update')->name('update');
        });
    });

    //Manage Reservation
    Route::controller('BookingController')->group(function () {
        Route::get('book-room', 'room')->name('book.room');
        
        Route::post('room-book', 'book')->name('room.book');
        Route::get('room/search', 'searchRoom')->name('room.search');
        
        
        Route::get('expense-category', 'expense')->name('expense.category');
        Route::get('mobile', 'mobile')->name('get.mobile');

        Route::name('booking.')->prefix('booking')->group(function () {
            Route::get('all-bookings', 'allBookingList')->name('all');
            Route::get('approved', 'activeBookings')->name('active');
            Route::post('filter_status', 'inactiveActiveStatus')->name('filter_status');

            Route::post('booking/cancel/{bookingId?}', 'cancelBooking')->name('cancel');
            Route::get('checked-out-booking', 'checkedOutBookingList')->name('checked_out.list');
            Route::get('cancelled-bookings', 'cancelledBookingList')->name('cancelled.list');
            Route::post('booking-merge/{id}', 'mergeBooking')->name('merge');

            Route::get('booking-checkout/{id}', 'checkOutPreview')->name('checkout');


            Route::post('booking/payment/partial/{id}', 'payment')->name('payment.partial');
            Route::post('booking-checkout/{id}', 'checkOut')->name('checkout');

            Route::get('booking-invoice/{bookingId}', 'generateInvoice')->name('invoice');

            Route::get('booking/details/{bookingId}', 'bookingDetails')->name('details');
            Route::get('booking/extra-service/details/{bookingId}', 'extraServiceDetail')->name('service.details');
            Route::get('booking/todays/booked-room', 'todaysBooked')->name('todays.booked');
            
            Route::post('update-room', 'update_room')->name('update_room');

        });

        Route::post('booked-room/cancel/{id}', 'cancelBookedRoom')->name('booked.room.cancel');
        Route::post('cancel-booking/{id}/{day}', 'cancelBookingByDate')->name('booked.day.cancel');
    });

    Route::controller('ManageBookingRequestController')->group(function () {
        Route::get('booking-requests', 'index')->name('booking.request.all');
        Route::get('booking-request/cancelled', 'cancelledBookings')->name('booking.request.cancelled');
        Route::get('booking-request-approve/{id}', 'approve')->name('booking.request.approve');
        Route::post('booking-request-cancel/{id}', 'cancel')->name('booking.request.cancel');
        Route::post('assign-room', 'assignRoom')->name('assign.room');
    });

    // Subscriber
    Route::controller('SubscriberController')->group(function () {
        Route::get('subscriber', 'index')->name('subscriber.index');
        Route::get('subscriber/send-email', 'sendEmailForm')->name('subscriber.send.email');
        Route::post('subscriber/remove/{id}', 'remove')->name('subscriber.remove');
        Route::post('subscriber/send-email', 'sendEmail')->name('subscriber.send.email');
    });


    // Deposit Gateway
    Route::name('gateway.')->prefix('gateway')->group(function () {

        // Automatic Gateway
        Route::controller('AutomaticGatewayController')->group(function () {
            Route::get('automatic', 'index')->name('automatic.index');
            Route::get('automatic/edit/{alias}', 'edit')->name('automatic.edit');
            Route::post('automatic/update/{code}', 'update')->name('automatic.update');
            Route::post('automatic/remove/{id}', 'remove')->name('automatic.remove');
            Route::post('automatic/activate/{code}', 'activate')->name('automatic.activate');
            Route::post('automatic/deactivate/{code}', 'deactivate')->name('automatic.deactivate');
        });


        // Manual Methods
        Route::controller('ManualGatewayController')->group(function () {
            Route::get('manual', 'index')->name('manual.index');
            Route::get('manual/new', 'create')->name('manual.create');
            Route::post('manual/new', 'store')->name('manual.store');
            Route::get('manual/edit/{alias}', 'edit')->name('manual.edit');
            Route::post('manual/update/{id}', 'update')->name('manual.update');
            Route::post('manual/activate/{code}', 'activate')->name('manual.activate');
            Route::post('manual/deactivate/{code}', 'deactivate')->name('manual.deactivate');
        });
    });


    // PAYMENT SYSTEM
    Route::name('deposit.')->controller('DepositController')->prefix('payment')->group(function () {
        Route::get('/', 'deposit')->name('list');
        Route::get('pending', 'pending')->name('pending');
        Route::get('rejected', 'rejected')->name('rejected');
        Route::get('approved', 'approved')->name('approved');
        Route::get('successful', 'successful')->name('successful');
        Route::get('failed', 'failed')->name('failed');
        Route::get('details/{id}', 'details')->name('details');

        Route::post('reject', 'reject')->name('reject');
        Route::post('approve/{id}', 'approve')->name('approve');
    });

    // Report
    Route::controller('ReportController')->group(function () {
        Route::get('report/login/history', 'loginHistory')->name('report.login.history');
        Route::get('report/login/ipHistory/{ip}', 'loginIpHistory')->name('report.login.ipHistory');
        Route::get('report/notification/history', 'notificationHistory')->name('report.notification.history');
        Route::get('report/email/detail/{id}', 'emailDetails')->name('report.email.details');
        Route::get('report/booking-actions', 'bookingActionHistory')->name('report.booking.history');
        Route::get('report/payments/received/history', 'paymentsReceived')->name('report.payments.received');
        Route::get('report/payment/returned/history', 'paymentReturned')->name('report.payments.returned');
    });


    // Admin Support
    Route::controller('SupportTicketController')->group(function () {
        Route::get('tickets', 'tickets')->name('ticket');
        Route::get('tickets/pending', 'pendingTicket')->name('ticket.pending');
        Route::get('tickets/closed', 'closedTicket')->name('ticket.closed');
        Route::get('tickets/answered', 'answeredTicket')->name('ticket.answered');
        Route::get('tickets/view/{id}', 'ticketReply')->name('ticket.view');
        Route::post('ticket/reply/{id}', 'replyTicket')->name('ticket.reply');
        Route::get('ticket/download/{ticket}', 'ticketDownload')->name('ticket.download');
        Route::post('ticket/delete/{id}', 'ticketDelete')->name('ticket.delete');
    });

    // Language Manager
    Route::controller('LanguageController')->group(function () {
        Route::get('/language', 'langManage')->name('language.manage');
        Route::post('/language', 'langStore')->name('language.manage.store');
        Route::post('/language/delete/{id}', 'langDelete')->name('language.manage.delete');
        Route::post('/language/update/{id}', 'langUpdate')->name('language.manage.update');
        Route::get('/language/edit/{id}', 'langEdit')->name('language.key');
        Route::post('/language/import', 'langImport')->name('language.import.lang');
        Route::post('language/store/key/{id}', 'storeLanguageJson')->name('language.store.key');
        Route::post('language/delete/key/{id}', 'deleteLanguageJson')->name('language.delete.key');
        Route::post('language/update/key/{id}', 'updateLanguageJson')->name('language.update.key');
    });

    Route::controller('GeneralSettingController')->group(function () {
        // General Setting
        Route::get('general-setting', 'index')->name('setting.index');
        Route::post('general-setting', 'update')->name('setting.update');

        //configuration
        Route::get('setting/system-configuration', 'systemConfiguration')->name('setting.system.configuration');
        Route::post('setting/system-configuration', 'systemConfigurationSubmit');

        // Logo-Icon
        Route::get('setting/logo-icon', 'logoIcon')->name('setting.logo.icon');
        Route::post('setting/logo-icon', 'logoIconUpdate')->name('setting.logo.icon');

        //Custom CSS
        Route::get('custom-css', 'customCss')->name('setting.custom.css');
        Route::post('custom-css', 'customCssSubmit');

        //Cookie
        Route::get('cookie', 'cookie')->name('setting.cookie');
        Route::post('cookie', 'cookieSubmit');

        //maintenance_mode
        Route::get('maintenance-mode', 'maintenanceMode')->name('maintenance.mode');
        Route::post('maintenance-mode', 'maintenanceModeSubmit');
    });

    //Notification Setting
    Route::name('setting.notification.')->controller('NotificationController')->prefix('notification')->group(function () {
        //Template Setting
        Route::get('global', 'global')->name('global');
        Route::post('global/update', 'globalUpdate')->name('global.update');
        Route::get('templates', 'templates')->name('templates');
        Route::get('template/edit/{id}', 'templateEdit')->name('template.edit');
        Route::post('template/update/{id}', 'templateUpdate')->name('template.update');

        //Email Setting
        Route::get('email/setting', 'emailSetting')->name('email');
        Route::post('email/setting', 'emailSettingUpdate');
        Route::post('email/test', 'emailTest')->name('email.test');

        //SMS Setting
        Route::get('sms/setting', 'smsSetting')->name('sms');
        Route::post('sms/setting', 'smsSettingUpdate');
        Route::post('sms/test', 'smsTest')->name('sms.test');
    });

    // Plugin
    Route::controller('ExtensionController')->group(function () {
        Route::get('extensions', 'index')->name('extensions.index');
        Route::post('extensions/update/{id}', 'update')->name('extensions.update');
        Route::post('extensions/status/{id}', 'status')->name('extensions.status');
    });


    //System Information
    Route::controller('SystemController')->name('system.')->prefix('system')->group(function () {
        Route::get('support', 'support')->name('support');
        Route::get('info', 'systemInfo')->name('info');
        Route::get('server-info', 'systemServerInfo')->name('server.info');
        Route::get('optimize', 'optimize')->name('optimize');
        Route::get('optimize-clear', 'optimizeClear')->name('optimize.clear');
    });

    // SEO
    Route::get('seo', 'FrontendController@seoEdit')->name('seo');


    // Frontend
    Route::name('frontend.')->prefix('frontend')->group(function () {
        Route::controller('FrontendController')->group(function () {
            Route::get('templates', 'templates')->name('templates');
            Route::post('templates', 'templatesActive')->name('templates.active');
            Route::get('frontend-sections/{key}', 'frontendSections')->name('sections');
            Route::post('frontend-content/{key}', 'frontendContent')->name('sections.content');
            Route::get('frontend-element/{key}/{id?}', 'frontendElement')->name('sections.element');
            Route::post('remove/{id}', 'remove')->name('remove');
        });

        // Page Builder
        Route::controller('PageBuilderController')->group(function () {
            Route::get('manage-pages', 'managePages')->name('manage.pages');
            Route::post('manage-pages', 'managePagesSave')->name('manage.pages.save');
            Route::post('manage-pages/update', 'managePagesUpdate')->name('manage.pages.update');
            Route::post('manage-pages/delete/{id}', 'managePagesDelete')->name('manage.pages.delete');
            Route::get('manage-section/{id}', 'manageSection')->name('manage.section');
            Route::post('manage-section/{id}', 'manageSectionUpdate')->name('manage.section.update');
        });
    });
});
