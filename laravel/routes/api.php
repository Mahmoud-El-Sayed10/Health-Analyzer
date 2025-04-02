<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ActivityLogController;
use App\Http\Controllers\Auth\RegisterController;
use Laravel\Passport\Http\Controllers\AccessTokenController;

// Public route: Signup
Route::post('/register', [RegisterController::class, 'register']);

Route::post('/oauth/token', [AccessTokenController::class, 'issueToken'])
    ->middleware(['throttle', 'api'])
    ->name('passport.token');

// Protected routes: CSV upload etc.
Route::middleware('auth:api')->group(function () {
    Route::post('/upload-csv', [ActivityLogController::class, 'uploadCsv']);
});

