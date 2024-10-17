<?php

use App\Http\Controllers\Admin\RoleController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
*/

Route::group([
    'prefix' => 'roles',
    'as' => 'roles.'
], function () {
    Route::resource('/', RoleController::class)->parameters(['' => 'role']);
});