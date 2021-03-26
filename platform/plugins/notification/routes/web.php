<?php

Route::group(['namespace' => 'Platform\Notification\Http\Controllers', 'middleware' => ['web', 'core']], function () {

    Route::group(['prefix' => BaseHelper::getAdminPrefix(), 'middleware' => 'auth'], function () {

        Route::group(['prefix' => 'notifications', 'as' => 'notification.'], function () {
            Route::resource('', 'NotificationController')->parameters(['' => 'notification']);
            Route::delete('items/destroy', [
                'as'         => 'deletes',
                'uses'       => 'NotificationController@deletes',
                'permission' => 'notification.destroy',
            ]);
        });
    });

});
