<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\QRCodeController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PlanController;
use App\Http\Controllers\SuperAdminController;
use App\Http\Controllers\EmailController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\LinksController;
use App\Http\Controllers\AccountController;
use App\Http\Controllers\AppSettingsController;
use App\Http\Controllers\Auth\SocialiteController;
use App\Http\Controllers\LinkItemsController;
use App\Http\Controllers\FileUploadController;
use App\Http\Controllers\PaymentSettingsController;
use App\Http\Controllers\SubscriptionController;

use App\Http\Controllers\Gateways\MollieController;
use App\Http\Controllers\Gateways\RazorpayController;
use App\Http\Controllers\Gateways\PaypalController;
use App\Http\Controllers\Gateways\PaystackController;
use App\Http\Controllers\Gateways\StripeController;
use App\Http\Controllers\SetupController;
use App\Http\Controllers\TestDbController;
use App\Http\Controllers\VersionUpdateController;
use Illuminate\Http\Request;



$installed = Storage::disk('public')->exists('installed');

Route::get('/', function (Request $request) {
    $filePath = 'installed';
    $installed = Storage::disk('public')->exists('installed');

    if ($installed === true) {
        return app('App\Http\Controllers\HomeController')->Home($request);
    } else {
        return redirect('/setup');
    }
});



if ($installed === true) {
    Auth::routes();

    Route::middleware(['auth','web'])->prefix('email')->group(function () {
        Route::get('/verify', [EmailController::class, 'VerifyEmail'])->name('verification.notice');
        Route::get('/verify/{id}/{hash}', [EmailController::class, 'SendVerifyEmail'])->middleware(['signed'])->name('verification.verify');
        Route::post('/verification-notification', [EmailController::class, 'ReSendVerifyEmail'])->middleware(['throttle:6,1'])->name('verification.resend');
    });

    Route::get('auth/google', [SocialiteController::class, 'google']);
    Route::get('auth/google/callback', [SocialiteController::class, 'google_callback']);

    Route::middleware(['auth','web', 'verified', 'role:SUPER-ADMIN|PREMIUM|STANDARD|BASIC', 'next_payment'])->prefix('/dashboard')->group(function () {
        Route::get('/', [DashboardController::class, 'index']);

        //Plans Routes Start
        Route::get('/plan', [PlanController::class, 'UserPlan'])->name('plan');
        Route::get('/plan-update', [PlanController::class, 'GetPlan'])->name('plan-update');
        Route::post('/basic-plan/{id}', [PlanController::class, 'BasicPlan'])->name('basic-plan');
        //Plans Routes End

        //Subscription Routes
        Route::get('/billing/{id}', [SubscriptionController::class, 'Billing'])->name('billing');
        //Subscription Routes End

        // QR-Code routes start
        Route::get('/qrcodes', [QRCodeController::class, 'GetQRCodes']);
        Route::get('/project-qrcodes/{projectId}', [QRCodeController::class, 'GetProjectQRCodes']);
        Route::post('/add-link-qrcode/{linkId}', [QRCodeController::class, 'AddLinkQRCode']);
        Route::get('/create-qrcode', [QRCodeController::class, 'CreateQRCode'])->middleware('check_payment');
        Route::post('/save-qrcode', [QRCodeController::class, 'InsertQRCode']);
        Route::delete('/delete-qrcode/{qrCodeId}', [QRCodeController::class, 'DeleteQRCode']);
        // QR-Code routes end

        // Project routes start
        Route::get('/project', [ProjectController::class, 'Project']);
        Route::post('/create-project', [ProjectController::class, 'CreateProject'])->middleware('check_payment');
        Route::put('/update-project/{projectId}', [ProjectController::class, 'UpdateProject'])->middleware('check_payment');
        Route::delete('/delete-project/{projectId}', [ProjectController::class, 'DeleteProject']);
        // Project routes end

        // Theme routes start
        Route::put('/theme-update/{themeId}/{linkId}', [LinksController::class, 'ThemeUpdate'])->middleware('check_payment');
        Route::post('/create-custom-theme/{linkId}', [LinksController::class, 'AddCustomTheme'])->middleware('check_payment');
        Route::put('/update-custom-theme/{themeId}', [LinksController::class, 'UpdateCustomTheme'])->middleware('check_payment');
        Route::put('/active-custom-theme/{linkId}', [LinksController::class, 'ActiveCustomTheme'])->middleware('check_payment');
        // Theme routes end

        // Link routes start
        Route::get('/links', [LinksController::class, 'BioLinks']);
        Route::get('/short-links', [LinksController::class, 'GetShortLinks']);
        Route::post('/create-link', [LinksController::class, 'CreateLink'])->middleware('check_payment');
        Route::put('/update-link/{linkId}', [LinksController::class, 'UpdateLink'])->middleware('check_payment');
        Route::put('/update-link-logo/{linkId}', [LinksController::class, 'UpdateLinkLogo'])->middleware('check_payment');
        Route::put('/update-link-profile/{linkId}', [LinksController::class, 'UpdateLinkProfile'])->middleware('check_payment');
        Route::put('/update-link-socials/{linkId}', [LinksController::class, 'UpdateLinkSocials'])->middleware('check_payment');
        Route::delete('/delete-link/{linkId}', [LinksController::class, 'DeleteLink']);
        Route::get('/biolink/analytics/{linkId}/{statistics}', [LinksController::class, 'BioLinkAnalytics']);
        // Link routes end

        // Bio-link items routes start
        Route::get('/biolink/{linkUrl}', [LinkItemsController::class, 'EditBioLink']);
        Route::post('/biolink/add-item', [LinkItemsController::class, 'AddLinkItem'])->middleware('check_payment');
        Route::put('/biolink/edit-item/{itemId}', [LinkItemsController::class, 'EditLinkItem'])->middleware('check_payment');
        Route::put('/biolink/update-position', [LinkItemsController::class, 'UpdateItemPosition']);
        Route::delete('/biolink/delete-item/{itemId}', [LinkItemsController::class, 'DeleteLinkItem']);
        Route::post('/link/settings-btn', [LinkItemsController::class, 'BtnController']);
        // Bio-link items routes end

        // Account settings routes start
        Route::prefix('/account')->group(function () {
            Route::get('/{activeElement}', [AccountController::class, 'GetAccount']);
            Route::put('/update-setting', [AccountController::class, 'UpdateSetting']);
            Route::post('/update-email', [AccountController::class, 'UpdateEmail']);
            Route::post('/update-password', [AccountController::class, 'UpdatePassword']);
        });
        // Account settings routes end

        // Paypal routes start
        Route::post('paypal/payment', [PaypalController::class, 'payment'])->name('paypal.payment');
        Route::get('paypal/success', [PaypalController::class, 'success'])->name('paypal.success');
        Route::get('paypal/cancel', [PaypalController::class, 'cancel'])->name('paypal.cancel');

        // Paypal routes start
        Route::post('stripe/payment', [StripeController::class, 'payment'])->name('stripe.payment');
        Route::get('stripe/success', [StripeController::class, 'success'])->name('stripe.success');
        Route::get('stripe/cancel', [StripeController::class, 'cancel'])->name('stripe.cancel');

        // Razorpay routes start
        Route::get('razorpay/form', [RazorpayController::class, 'show_form'])->name('razorpay.form');
        Route::post('razorpay/payment', [RazorpayController::class, 'payment'])->name('razorpay.payment');
        
        // mollie routes start
        Route::post('mollie/payment', [MollieController::class, 'payment'])->name('mollie.payment');
        Route::get('mollie/success', [MollieController::class, 'success'])->name('mollie.success');

        // paystack routes start
        Route::get('paystack/redirect', [PaystackController::class, 'paystack_redirect'])->name('paystack.redirect');
        Route::get('paystack/callback', [PaystackController::class, 'verify_transaction'])->name('paystack.callback');
        
        Route::post('/single-upload', [FileUploadController::class, 'SingleUpload']);
    });


    // Only admin routes
    Route::middleware(['auth','web', 'verified', 'role:SUPER-ADMIN', 'next_payment'])->prefix('/dashboard')->group(function () {
        Route::get('/users', [SuperAdminController::class, 'index']);
        Route::put('/users/{id}', [SuperAdminController::class, 'UpdateUser'])->name('user-update');
        Route::get('/themes', [SuperAdminController::class, 'ManageThemes']);
        Route::put('/themes/type/{id}', [SuperAdminController::class, 'TypeThemes']);
        Route::put('/themes/free/{themeId}', [SuperAdminController::class, 'FreeThemes']);
        Route::put('/themes/premium/{themeId}', [SuperAdminController::class, 'PremiumThemes']);
        Route::get('/subscription-history', [SubscriptionController::class, 'SubscriptionHistory']);
        
        //Testimonials Routes Started
        Route::get('/testimonials', [SuperAdminController::class, 'Testimonials']);
        Route::post('/testimonial/add', [SuperAdminController::class, 'AddTestimonial']);
        Route::delete('/testimonial/delete/{testimonialId}', [SuperAdminController::class, 'DeleteTestimonial']);
        //Testimonials Routes End

        //Plans Routes Start
        Route::prefix('/plans')->group(function () {
            Route::get('/', [PlanController::class, 'GetPlan'])->name('plans');
            Route::get('/create', [PlanController::class, 'CreatePlan'])->name('plan.create');
            Route::post('/store', [PlanController::class, 'StorePlan'])->name('plan.store');
            Route::get('/update/{id}', [PlanController::class, 'GetPlanUpdate'])->name('plan.update');
            Route::put('/update/{id}', [PlanController::class, 'PlanUpdate'])->name('plan.update');
        });

        Route::post('/plan/create', [PlanController::class, 'CreatePlan']);
        Route::put('/plan/update/{planId}', [PlanController::class, 'PlanUpdate']);
        //Plans Routes End


        //---------- App Settings routes start ----------//
        Route::prefix('/app-settings')->group(function () {
            Route::get('/', [AppSettingsController::class, 'index']);
            
            Route::put('/global/update', [AppSettingsController::class, 'global_update'])->name('settings.global');
            Route::put('/auth/google', [AppSettingsController::class, 'auth_google'])->name('settings.google');
            Route::put('/smtp/update', [AppSettingsController::class, 'smtp_update'])->name('settings.smtp');
        });
        //---------- App Settings routes end ----------// 


        //---------- Payment Settings routes start ----------//
        Route::prefix('/payment-settings')->group(function () {
            Route::get('/', [PaymentSettingsController::class, 'index']);
            
            Route::put('/payment/stripe', [PaymentSettingsController::class, 'stripe_update'])->name('settings.stripe');
            Route::put('/payment/razorpay', [PaymentSettingsController::class, 'razorpay_update'])->name('settings.razorpay');
            Route::put('/payment/two-checkout', [PaymentSettingsController::class, 'two_checkout_update'])->name('settings.two-checkout');
            Route::put('/payment/paypal', [PaymentSettingsController::class, 'paypal_update'])->name('settings.paypal');
            Route::put('/payment/mollie', [PaymentSettingsController::class, 'mollie_update'])->name('settings.mollie');
            Route::put('/payment/paystack', [PaymentSettingsController::class, 'paystack_update'])->name('settings.paystack');
        });
        //---------- Payment Settings routes end ----------// 
    });


    // Intro page update for only admin
    Route::middleware(['auth','web', 'verified', 'role:SUPER-ADMIN', 'check_payment'])->prefix('home-section')->group(function () {
        Route::put('/edit/{sectionId}', [HomeController::class, 'EditHomeSection']);
        Route::put('/edit-list/{sectionId}', [HomeController::class, 'EditSectionList']);
    }); 
    
    // Version Update for only admin
    Route::get('/version/update', [VersionUpdateController::class, 'index']);
    Route::post('/admin/login', [VersionUpdateController::class, 'admin_login']);
    Route::middleware(['auth','web'])->group(function () {
        Route::get('/version/update/step-2', [VersionUpdateController::class, 'update']);
        Route::post('/version/update', [VersionUpdateController::class, 'store']);
    }); 
    
    Route::post('/file-upload/{prevImage}', [FileUploadController::class, 'SingleFileUpload']);
    Route::get('/{lastLink}', [LinksController::class, 'GetLink']);

} else {

    Route::get('/{url?}',
    function () {
            return redirect('/setup');
    })->where('url', '^(?!setup).*$');


    Route::get('/setup', [SetupController::class, 'viewCheck'])->name('setup');
    Route::get('/setup/step-1', [SetupController::class, 'viewStep1'])->name('viewStep1');
    Route::post('/setup/step-2', [SetupController::class, 'setupStep1'])->name('setupStep1');
    Route::post('/setup/testDB', [TestDbController::class, 'testDB'])->name('testDB');
    Route::get('/setup/step-2', [SetupController::class, 'viewStep2'])->name('viewStep2');
    Route::get('/setup/step-3', [SetupController::class, 'viewStep3'])->name('viewStep3');

    Route::get('/setup/finish', function () {

        return view('setup.finishedSetup');
    });

    Route::get('/setup/getNewAppKey', [SetupController::class, 'getNewAppKey'])->name('getNewAppKey');
    Route::post('/setup/step-3', [SetupController::class, 'setupStep2'])->name('setupStep2');
    Route::post('/setup/step-4', [SetupController::class, 'setupStep3'])->name('setupStep3');
    Route::post('/setup/step-5', [SetupController::class, 'setupStep4'])->name('setupStep4');
    Route::post('/setup/lastStep', [SetupController::class, 'lastStep'])->name('lastStep');

    Route::get('/setup/lastStep', function () {
        return redirect('/setup', 301);
    });
}

