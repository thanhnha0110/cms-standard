<?php

use App\Http\Controllers\Admin\LogController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
*/

Route::group([
    'prefix' => 'logs',
    'as' => 'logs.'
], function () {
    Route::get('', [LogController::class, 'index'])->name('index');
});