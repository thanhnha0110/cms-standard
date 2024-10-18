<?php

use App\Http\Controllers\Admin\AuthController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
*/

Route::get('', [AuthController::class, 'getLogin'])->name('get.login');;
Route::post('', [AuthController::class, 'postLogin'])->name('post.login');
Route::get('logout', [AuthController::class, 'logout'])->name('logout');