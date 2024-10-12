<?php

use App\Http\Controllers\Admin\UserController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| GET /users → index()
| GET /users/create → create()
| POST /users → store()
| GET /users/{user} → show()
| GET /users/{user}/edit → edit()
| PUT/PATCH /users/{user} → update()
| DELETE /users/{user} → destroy()
| users.index
| users.create
| users.store
| users.show
| users.edit
| users.update
| users.destroy
| users.analytics
|
*/

Route::group([
    'prefix' => 'users',
    'as' => 'users.'
], function () {

    Route::resource('/', UserController::class);

    Route::get('analytics', [UserController::class, 'analytics'])->name('analytics');
});