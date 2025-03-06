<?php

use App\Http\Controllers\FrontEnd\CartController;
use App\Http\Controllers\FrontEnd\CourseController;
use App\Http\Controllers\Frontend\User\AuthController;
use App\Http\Controllers\ProfileController;
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
    'middleware'=>'UserStatusCheckMid'
],function(){
    Route::get('/', function () {
        // App::setLocale(env('FRONT_LOCALE'));
        return view('frontend.blade.homepage.index');
    });
    
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->middleware(['auth', 'verified'])->name('dashboard');
    
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
            Route::get('/add-to-cart/{slug}','addCart')->name('addCart');
            Route::get('/delete-from-cart/{slug}','deleteCart')->name('deleteCart');
            Route::get('/view/cart','viewCart')->name('viewCart');
            Route::get('/apply-coupon','applyCoupon')->name('applyCoupon');
            Route::post('/cart-payment','cartPayment')->name('cartPayment');
        });
    });
});


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





// require __DIR__.'/auth.php';
