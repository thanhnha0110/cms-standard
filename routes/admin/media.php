<?php

use App\Http\Controllers\Admin\MediaController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
*/

Route::group([
    'prefix' => 'media',
    'as' => 'media.'
], function () {
    Route::resource('/', MediaController::class)->parameters(['' => 'media']);
});