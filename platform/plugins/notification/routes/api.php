<?php

use Illuminate\Support\Facades\Route;

Route::group([
    'middleware' => 'api',
    'prefix' => 'api/v1',
    'namespace' => 'Platform\Notification\Http\Controllers\API',
], function () {
    Route::group([
        'middleware' => ['auth:member-api']
    ], function () {
        Route::resource('notification', 'NotificationController')->except('create')->parameters('notification');
    });
});