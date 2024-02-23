<?php

use App\Http\Controllers\v1\FeatureController;
use App\Http\Controllers\v1\Profile\ProfileController;
use App\Http\Controllers\v1\Profile\ProfileImageController;
use App\Http\Controllers\v1\Profile\ProfileNotificationController;
use App\Http\Controllers\v1\Profile\ProfileSubscriptionController;
use App\Http\Controllers\v1\UserController;
use App\Http\Controllers\v1\UserInvitationController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/


Route::middleware(['auth:sanctum', 'verified'])->group(function () {
    Route::controller(ProfileController::class)
        ->prefix('/profile')
        ->group(function () {
            Route::get('/', 'show')->name('profile.show');
            Route::patch('/', 'update')->name('profile.update');
            Route::delete('/', 'destroy')->name('profile.destroy');
        });
    Route::get('/profile/subscription', ProfileSubscriptionController::class)
        ->name('profile-subscription.show');
    Route::post('/profile/image', [ProfileImageController::class, 'store'])
        ->name('profile-image.store');
    Route::delete('/profile/image', [ProfileImageController::class, 'destroy'])
        ->name('profile-image.destroy');
    Route::get('/profile/image/status', [ProfileImageController::class, 'status'])
        ->name('profile-image.status');
    Route::get('/profile/notifications', [ProfileNotificationController::class, 'show'])
        ->name('profile-notification.show');
    Route::patch('/profile/notifications', [ProfileNotificationController::class, 'update'])
        ->name('profile-notification.update');

    Route::patch('/users/{id}', [UserController::class, 'updateUser'])->name('users.update')->can('update user');
    Route::delete('/users/{id}', [UserController::class, 'destroy'])->name('users.delete')->can('delete user');
    Route::get('/users/{id}', [UserController::class, 'get'])->name('users.get')->can('views user');
    Route::get('/users', [UserController::class, 'index'])->name('users.index')->can('view users');

    Route::controller(UserInvitationController::class)
        ->prefix('/invitations')
        ->group(function () {
            Route::get('/', 'index')->name('invitations.index')->can('view users');
            Route::post('/', 'store')->name('invitations.store')->can('create user');
            Route::delete('/{id}', 'destroy')->name('invitations.destroy')->can('create user');
        });
});

Route::get('/features', [FeatureController::class, 'index'])->name('features.index');

Route::get('/', function () {
    return ['Symfony' => 2.9];
})->name('home.api');

Route::get('/error-track', [UserController::class, 'indexing']);
require __DIR__ . '/auth.php';
