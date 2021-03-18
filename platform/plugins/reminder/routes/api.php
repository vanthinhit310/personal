<?php


use Illuminate\Support\Facades\Route;

Route::group([
    'middleware' => 'api',
    'prefix' => 'api/v1',
    'namespace' => 'Platform\Reminder\Http\Controllers\API',
], function () {
    Route::group([
        'middleware' => ['auth:member-api']
    ], function () {
        Route::resource('reminder', 'ReminderController')->except('create')->parameters('reminder');
        Route::post('reminder/bulk-delete', 'ReminderController@bulkDelete')->name('reminder.bulkDelete');
    });
});
