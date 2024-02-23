<?php

use Modules\Profile\Http\Controllers\v1\ProfileController;
use Modules\Profile\Http\Controllers\v1\ProfileImageController;
use Modules\Profile\Http\Controllers\v1\ProfileSubscriptionController;
use Modules\Profile\Http\Controllers\v1\ProfileNotificationController;

Route::middleware(['auth:sanctum', 'verified'])->group(function () {
    Route::controller(ProfileController::class)
        ->prefix('api/v2/profile')
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
});