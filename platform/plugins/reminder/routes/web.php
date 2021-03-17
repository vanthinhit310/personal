<?php

Route::group(['namespace' => 'Platform\Reminder\Http\Controllers', 'middleware' => ['web', 'core']], function () {

    Route::group(['prefix' => BaseHelper::getAdminPrefix(), 'middleware' => 'auth'], function () {

        Route::group(['prefix' => 'reminders', 'as' => 'reminder.'], function () {
            Route::resource('', 'ReminderController')->parameters(['' => 'reminder']);
            Route::delete('items/destroy', [
                'as'         => 'deletes',
                'uses'       => 'ReminderController@deletes',
                'permission' => 'reminder.destroy',
            ]);
        });
    });

});
