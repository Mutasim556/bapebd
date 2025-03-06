<?php

use App\Http\Controllers\Admin\Course\Category\CategoryController;
use App\Http\Controllers\Admin\Course\CourseController;
use App\Http\Controllers\Admin\Course\CouponController;
use App\Http\Controllers\Admin\Course\SubCategory\SubCategoryController;
use Illuminate\Support\Facades\Route;
use Stichoza\GoogleTranslate\GoogleTranslate;

Route::group([
    'middleware'=>['admin','adminStatusCheck'],
],function(){
    Route::prefix('course')->name('course.')->group(function(){

        /** Category */
        Route::resource('category',CategoryController::class)->except('create','show');
        Route::controller(CategoryController::class)->prefix('category')->group(function () {
            Route::get('/update/status/{id}/{status}', 'updateStatus');
            Route::get('/get/category-details/{id}/{target}', 'getCategoryDetails');
        });
    
        /** Sub Category */
        Route::resource('subCategory',SubCategoryController::class)->except('create','show');
        Route::controller(SubCategoryController::class)->prefix('subCategory')->group(function () {
            Route::get('/update/status/{id}/{status}', 'updateStatus');
        });

        /** Cuppon */
        Route::resource('coupon',CouponController::class)->except('create');
        Route::controller(CouponController::class)->prefix('coupon')->group(function () {
            Route::get('/update/status/{id}/{status}', 'updateStatus');
        });
    
    });
    
    /** Courses */
    Route::resource('course',CourseController::class);
    Route::controller(CourseController::class)->prefix('course')->group(function () {
        Route::get('/get/subcategory', 'getSubCategories');
        Route::get('/update/status/{id}/{status}', 'updateStatus');
        Route::get('/live/batch/status/{id}/{status}', 'liveBatchStatus');
        Route::get('/recorded/status/update/{id}/{status}', 'recordedStatus');
        Route::get('/recorded/data/{id}/edit', 'recordedEdit');
        Route::put('/recorded/data/update/{id}', 'recordedUpdate');
        Route::get('/live/data/{id}/edit', 'liveEdit');
        Route::put('/live/data/update/{id}', 'liveUpdate');
        Route::delete('/live/delete/{id}', 'liveDestroy');
        Route::delete('/recorded/delete/{id}', 'recordedDestroy');
        
        Route::post('/video/upload','videoUpload');
        Route::post('/batch/upload','batchUpload');
    });
    
    Route::get('/translate-string',function(){
        $data = [];
        $langs = getLangs();
        foreach($langs as $lang){
            $darr =  GoogleTranslate::trans(request()->tdata, $lang->lang, 'en');
            array_push($data,$darr);
        }
        return [
            'tdata'=>$data,
            'langs'=>$langs 
        ];
    })->name('translateString');
});

