<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

include_once 'admin/auth.php';

Route::group([
    'prefix' => 'admin',
    'middleware' => ['auth']
], function () {

    // Autoload all files in the admin folder
    foreach (glob(__DIR__ . '/admin/*.php') as $file) {
        include_once $file;
    }
});