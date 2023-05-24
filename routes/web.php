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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

// Route::get('/admin', [App\Http\Controllers\AdminController::class, 'index'])->name('admin');

Route::group(['namespace' => 'App\Http\Controllers\Admin', 'prefix' => 'admin'], function () {

    Route::group(['namespace' => 'User', 'prefix' => 'user'], function () {
        Route::get('/', 'UserController@index')->name('admin.user');
    });
    Route::group(['namespace' => 'Celebrant', 'prefix' => 'celebrant'], function () {
        Route::get('/', 'CelebrantController@index')->name('admin.celebrant');
    });
    Route::group(['namespace' => 'Greeting', 'prefix' => 'greeting'], function () {
        Route::get('/', 'GreetingController@index')->name('admin.greeting');
    });
});
  
        
