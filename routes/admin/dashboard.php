<?php

use App\Http\Controllers\Admin\DashboardController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
*/

Route::group([
    'prefix' => 'dashboard',
    'as' => 'dashboard.'
], function () {
    Route::get('', [DashboardController::class, 'index'])->name('index');
});