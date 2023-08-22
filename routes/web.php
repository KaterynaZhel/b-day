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

Route::prefix('admin')->middleware(['auth', 'isAdmin'])->group(function () {
    Route::resources([
        'users' => App\Http\Controllers\Admin\User\UserController::class,
        'celebrants' => App\Http\Controllers\Admin\Celebrant\CelebrantController::class,
        'greetings' => App\Http\Controllers\Admin\Greeting\GreetingController::class,
        'celebrants.greetingsCompany' => App\Http\Controllers\Admin\Greeting\GreetingCompanyController::class,
        'mainGreetingsCompany' => App\Http\Controllers\Admin\Greeting\MainGreetingCompanyController::class,
        'companies' => App\Http\Controllers\Admin\Company\CompanyController::class,
    ], [
        'as' => 'admin'
    ]);
    Route::get('/nearestCelebrants', [App\Http\Controllers\Admin\Celebrant\CelebrantController::class, 'nearestCelebrants'])->name('admin.celebrants.nearestCelebrants');
});
