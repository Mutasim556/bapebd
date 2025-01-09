<?php

use App\Http\Controllers\Admin\Course\Category\CategoryController;
use App\Http\Controllers\Admin\Course\SubCategory\SubCategoryController;
use Illuminate\Support\Facades\Route;


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


});
