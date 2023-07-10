<?php


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Models\Celebrant;
use Carbon\Carbon;

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