<?php

use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\PostController;
use App\Http\Controllers\Admin\TagController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
*/

Route::group([
    'prefix' => 'management',
    'as' => 'management.'
], function () {

    Route::group([
        'prefix' => 'categories',
        'as' => 'categories.'
    ], function () {
        Route::resource('/', CategoryController::class)->parameters(['' => 'category']);
    });

    Route::group([
        'prefix' => 'tags',
        'as' => 'tags.'
    ], function () {
        Route::resource('/', TagController::class)->parameters(['' => 'tag']);
    });
});