<?php

use App\Http\Controllers\Admin\CategoryController;
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
});