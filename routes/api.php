<?php


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::apiResource('celebrants', App\Http\Controllers\Api\CelebrantController::class)->only([
    'index'
]);

Route::apiResource('celebrants', App\Http\Controllers\Api\CelebrantController::class)->only([
    'show'
]);

Route::apiResource('greetings', App\Http\Controllers\Api\GreetingController::class)->only([
    'store',
]);

Route::get('/greetings/{celebrant_id}', [App\Http\Controllers\Api\GreetingController::class, 'index']);
Route::get('/greetingsCompany/{celebrant_id}', [App\Http\Controllers\Api\GreetingCompanyController::class, 'show']);

Route::prefix('manager')->group(function () {
    Route::post('/register', [App\Http\Controllers\ApiManager\RegisterController::class, 'register'])->name('manager.register');
    Route::post('/login', [App\Http\Controllers\ApiManager\LoginController::class, 'login'])->name('manager.login');
    Route::post('/refresh', [App\Http\Controllers\ApiManager\LoginController::class, 'refresh'])->name('manager.refresh');
    Route::get('/celebrants', [App\Http\Controllers\ApiManager\CelebrantController::class, 'index'])->name('manager.index');
});

Route::middleware(['auth:api', 'isManager'])->prefix('manager')->group(function () {
    Route::post('/logout', [App\Http\Controllers\ApiManager\LoginController::class, 'logout'])->name('manager.logout');
    Route::post('/me', [App\Http\Controllers\ApiManager\LoginController::class, 'me'])->name('manager.me');
});
