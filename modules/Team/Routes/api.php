<?php

Route::group(['prefix' => 'api/v1', 'middleware' => ['auth:sanctum', 'verified']], function () {
    Route::get('/team', function () {
        return ['Laravel' => 8.0];
    })->name('team.api');
});