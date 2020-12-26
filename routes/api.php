<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Users\UserController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Users\FriendController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Users\UserFileController;
use App\Http\Controllers\Notebooks\NoteController;
use App\Http\Controllers\Notebooks\NotebookController;
use App\Http\Controllers\Auth\PasswordResetController;
use App\Http\Controllers\Auth\VerificationController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
*/

/**
 * Auth Route
 */
Route::group([
    'middleware' => 'api',
    'prefix' => 'auth'
], function () {
    Route::post('login', [LoginController::class, 'login'])->name('login');
    Route::post('register', [RegisterController::class, 'register'])->name('register');

    Route::post('password/forgot', [PasswordResetController::class, 'forgetPassword'])->name('forgetPassword');
    Route::post('password/reset/{token}', [PasswordResetController::class, 'resetPassword'])->name('resetPassword');


    Route::post('verify_email/{token}', [VerificationController::class, 'verify'])->name('verify_email');
    Route::post('verify_email/resend', [VerificationController::class, 'resend'])->name('verify_email_resend');

    Route::group([
        'middleware' => 'auth:api'
    ], function () {
        Route::post('logout', [LoginController::class, 'logout'])->name('user.logout');
    });
});


/**
 * User Route
 */
Route::group([
    'middleware' => 'auth:api',
    'prefix' => 'users'
], function () {
    Route::get('me', [UserController::class, 'index'])->name('me');
    Route::post('me/file/upload', [UserFileController::class, 'store'])->name('me.file_upload');
    Route::get('me/friends', [UserController::class, 'getFriends'])->name('me.getFriends');
    Route::get('friend/toggle/{id}', [FriendController::class, 'toggleFriend'])->name('toggleFriend');
    Route::resource('notebook', NotebookController::class);
    Route::resource('note', NoteController::class)->only(['store', 'update', 'destroy']);
    Route::post('notebook/upload', [NoteBookController::class, 'upload']);
});
