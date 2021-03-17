<?php

Route::group(['namespace' => 'Platform\SpendingDiary\Http\Controllers', 'middleware' => ['web', 'core']], function () {

    Route::group(['prefix' => BaseHelper::getAdminPrefix(), 'middleware' => 'auth'], function () {

        Route::group(['prefix' => 'spending-diaries', 'as' => 'spending-diary.'], function () {
            Route::resource('', 'SpendingDiaryController')->parameters(['' => 'spending-diary']);
            Route::delete('items/destroy', [
                'as'         => 'deletes',
                'uses'       => 'SpendingDiaryController@deletes',
                'permission' => 'spending-diary.destroy',
            ]);
        });
    });

});
