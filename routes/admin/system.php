<?php

use App\Http\Controllers\Admin\LogController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\UserController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
*/

Route::group([
    'prefix' => 'system',
    'as' => 'system.'
], function () {

    Route::group([
        'prefix' => 'roles',
        'as' => 'roles.'
    ], function () {
        Route::resource('/', RoleController::class)->parameters(['' => 'role']);
    });

    Route::group([
        'prefix' => 'users',
        'as' => 'users.'
    ], function () {
        Route::resource('/', UserController::class)->parameters(['' => 'user']);

        Route::get('/{id}/profile', [UserController::class, 'profile'])->name('profile');
        Route::post('/{id}/profile', [UserController::class, 'updateProfile'])->name('profile.update');
    });

    Route::group([
        'prefix' => 'logs',
        'as' => 'logs.'
    ], function () {
        Route::get('', [LogController::class, 'index'])->name('index');
    });
});