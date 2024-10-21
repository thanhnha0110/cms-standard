<?php

use App\Http\Controllers\Admin\SettingController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
*/

Route::group([
    'prefix' => 'settings',
    'as' => 'settings.'
], function () {

    Route::group([
        'prefix' => 'general',
        'as' => 'general.'
    ], function () {
        Route::get('', [SettingController::class, 'getGeneral'])->name('get');
        Route::post('', [SettingController::class, 'postGeneral'])->name('post');
    });

    Route::group([
        'prefix' => 'email',
        'as' => 'email.'
    ], function () {
        Route::get('', [SettingController::class, 'getEmail'])->name('get');
        Route::post('', [SettingController::class, 'postEmail'])->name('post');
    });

    Route::group([
        'prefix' => 'api',
        'as' => 'api.'
    ], function () {
        Route::get('', [SettingController::class, 'getApi'])->name('get');
        Route::post('', [SettingController::class, 'postApi'])->name('post');
    });
});