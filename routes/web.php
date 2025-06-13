<?php

use App\Http\Controllers\FrontEnd\CartController;
use App\Http\Controllers\FrontEnd\ChangeFrontLanguageController;
use App\Http\Controllers\FrontEnd\CourseController;
use App\Http\Controllers\Frontend\OtherPageController;
use App\Http\Controllers\FrontEnd\ProfileController;
use App\Http\Controllers\Frontend\User\AuthController;
use App\Http\Controllers\SslCommerzPaymentController;
use App\Models\Admin\Comment;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Route;

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
Route::group([
    'middleware'=>'frontLocalization'
],function(){
    Route::group([
        'middleware'=>'UserStatusCheckMid'
    ],function(){
        Route::get('/', function () {
            // App::setLocale(env('FRONT_LOCALE'));
            return view('frontend.blade.homepage.index');
        })->name('HomePage');

        Route::get('/dashboard', function () {
            return view('dashboard');
        })->middleware(['admin', 'verified'])->name('dashboard');
        Route::get('change/language/{lang}',ChangeFrontLanguageController::class)->name('front.changeLanguage');
        Route::middleware('auth')->group(function () {
            Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
            Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
            Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
        });

        Route::group(['prefix'=>'courses','as'=>'frontend.courses.'],function(){
            Route::controller(CourseController::class)->group(function(){
                Route::get('{slug?}','viewCourse')->name('single');
                Route::get('/video/details/{video}','getVideoDetails')->name('video.details');
                Route::get('/all-courses/{type?}/{slug?}','getAllCourses')->name('getAllCourses');
            });
        });
        Route::group([
            'prefix'=>'course',
            'as'=>'frontend.course.',
            'middleware'=>'auth'
        ],function(){
            Route::controller(CartController::class)->group(function(){
                Route::get('/add-to-cart/{slug}/{type?}','addCart')->name('addCart');
                Route::get('/delete-from-cart/{slug}','deleteCart')->name('deleteCart');
                Route::get('/view/cart','viewCart')->name('viewCart');
                Route::get('/apply-coupon','applyCoupon')->name('applyCoupon');
                Route::post('/cart-payment','cartPayment')->name('cartPayment');

            });


        });
        Route::controller(ProfileController::class)->group(function(){
            Route::get('/my-profile','myProfile');
        })->middleware('auth');
        Route::controller(OtherPageController::class)->group(function(){
            Route::get('/about-us','aboutUs');
            Route::get('/contact-us','contactUs');
            Route::post('/send-messages','sendMessages')->name('sendMessages');

            Route::get('/all-instructor','allInstructor');
        });
    });
    // Route::post('/course/cart-payment/success',[CartController::class,'success']);
    // Route::post('/course/cart-payment/fail',[CartController::class,'fail']);
    // Route::post('/course/cart-payment/cancel',[CartController::class,'cancel']);
    // Route::post('/course/cart-payment/ipn',[CartController::class,'ipn']);

    Route::group([
        'prefix'=>'bipebd-user',
        'as'=>'user.',
        'middleware'=>'LoginStatusCheckMid'
    ],function(){
        Route::controller(AuthController::class)->group(function(){
            Route::get('/authentication/{type}','login')->name('login');
            Route::post('/login','attemptLogin')->name('attemptLogin');

            Route::post('/register','register')->name('register');
        });
    });
    Route::group([
        'prefix'=>'bipebd-user',
        'as'=>'user.',
        'middleware'=>'auth'
    ],function(){
        Route::get('/logout',[AuthController::class,'attemptLogout'])->name('attemptLogout');
    });


    Route::group([
        'middleware'=>'auth'
    ],function(){
    // SSLCOMMERZ Start
    Route::get('/example1', [SslCommerzPaymentController::class, 'exampleEasyCheckout']);
    Route::get('/example2', [SslCommerzPaymentController::class, 'exampleHostedCheckout']);

    Route::post('/pay', [SslCommerzPaymentController::class, 'index']);
    Route::post('/pay-via-ajax', [SslCommerzPaymentController::class, 'payViaAjax']);

    Route::post('/success', [SslCommerzPaymentController::class, 'success']);
    Route::post('/fail', [SslCommerzPaymentController::class, 'fail']);
    Route::post('/cancel', [SslCommerzPaymentController::class, 'cancel']);

    Route::post('/ipn', [SslCommerzPaymentController::class, 'ipn']);
    //SSLCOMMERZ END

    });
    // require __DIR__.'/auth.php';
});
