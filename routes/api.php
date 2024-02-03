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
});

Route::middleware(['auth:api', 'isManager'])->prefix('manager')->group(function () {
    Route::post('/logout', [App\Http\Controllers\ApiManager\LoginController::class, 'logout'])->name('manager.logout');
    Route::post('/me', [App\Http\Controllers\ApiManager\LoginController::class, 'me'])->name('manager.me');
    Route::get('/celebrants', [App\Http\Controllers\ApiManager\CelebrantController::class, 'index'])->name('manager.index');
    Route::get('/celebrant/{id}', [App\Http\Controllers\ApiManager\CelebrantController::class, 'show'])->name('manager.show');
    Route::get('/celebrant/votingStatistics/{id}', [App\Http\Controllers\ApiManager\CelebrantController::class, 'votingStatistics'])->name('manager.votingStatistics');
    Route::post('/celebrants', [App\Http\Controllers\ApiManager\CelebrantController::class, 'store'])->name('manager.store');
    Route::post('/celebrant/{id}', [App\Http\Controllers\ApiManager\CelebrantController::class, 'update'])->name('manager.update');
    Route::delete('/celebrants/{id}', [App\Http\Controllers\ApiManager\CelebrantController::class, 'destroy'])->name('manager.destroy');
    Route::get('/greetings', [App\Http\Controllers\ApiManager\GreetingController::class, 'index'])->name('manager.greetings.index');
    Route::delete('/greetings/{id}', [App\Http\Controllers\ApiManager\GreetingController::class, 'destroy'])->name('manager.destroy');
    Route::get('/greetingsCompany', [App\Http\Controllers\ApiManager\GreetingCompanyController::class, 'index'])->name('manager.greetingsCompany.index');
    Route::post('/greetingsCompany/{id}', [App\Http\Controllers\ApiManager\GreetingCompanyController::class, 'store'])->name('manager.greetingsCompany.store');
    Route::get('/showGreetingsCompanyForCelebrant/{id}', [App\Http\Controllers\ApiManager\GreetingCompanyController::class, 'showGreetingsCompanyForCelebrant'])->name('manager.greetingsCompany.showGreetingsCompanyForCelebrant');
    Route::get('/votes', [App\Http\Controllers\ApiManager\VoteController::class, 'index'])->name('manager.votes.index');
    Route::post('/votes/{id}', [App\Http\Controllers\ApiManager\VoteController::class, 'store'])->name('manager.votes.store');

    Route::get('/hobbies', [App\Http\Controllers\ApiManager\HobbyController::class, 'index']);
    Route::get('/positions', [App\Http\Controllers\ApiManager\PositionCelebrantController::class, 'index']);

    Route::get('/user/{id}', [App\Http\Controllers\ApiManager\UserController::class, 'show']);
    Route::post('/user/{id}', [App\Http\Controllers\ApiManager\UserController::class, 'update']);

    // Routes fot Chat GPT
    Route::post('/chat/{id}', [App\Http\Controllers\ChatGPT\ChatGPTController::class, 'askToChatGpt']);

    //storage of gift options
    Route::post('/giftOptions', [App\Http\Controllers\ApiManager\GiftOptionsController::class, 'store']);

    // Routes to send a voting email
    Route::post('/sendEmail', [App\Http\Controllers\Mail\EmailController::class, 'sendEmail']);

    //a list of colleagues to send an email to
    Route::get('/celebrantsEmails', [App\Http\Controllers\ApiManager\CelebrantController::class, 'emails']);
});

Route::get('/vote/{hash}', [App\Http\Controllers\Api\VoteController::class, 'show']);
Route::get('/vote/statistics/{hash}', [App\Http\Controllers\Api\VoteController::class, 'statistics']);
Route::post('/vote/voting/{hash}', [App\Http\Controllers\Api\VoteController::class, 'voting']);
