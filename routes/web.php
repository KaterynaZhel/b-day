<?php

use Illuminate\Support\Facades\Auth;
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

Route::get('/', function () {
    return view('welcome');
});

// Auth::routes();

// disable registration option
Auth::routes(['register' => false]);

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::group(['prefix' => 'admin'], function () {
    Route::resources([
        'user' => App\Http\Controllers\Admin\User\UserController::class,
        'celebrant' => App\Http\Controllers\Admin\Celebrant\CelebrantController::class,
        'greeting' => App\Http\Controllers\Admin\Greeting\GreetingController::class,
    ], [
        'as' => 'admin'
    ]);
});

Route::prefix('admin')->middleware(['auth', 'isAdmin'])->group(function () {
    Route::get('user', [App\Http\Controllers\Admin\User\UserController::class, 'index'])->name('admin.user.index');
    Route::get('celebrant', [App\Http\Controllers\Admin\Celebrant\CelebrantController::class, 'index'])->name('admin.celebrant.index');
    Route::get('greeting', [App\Http\Controllers\Admin\Greeting\GreetingController::class, 'index'])->name('admin.greeting.index');
});
