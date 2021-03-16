<?php

Route::group(['namespace' => 'Platform\TodoList\Http\Controllers', 'middleware' => ['web', 'core']], function () {

    Route::group(['prefix' => BaseHelper::getAdminPrefix(), 'middleware' => 'auth'], function () {

        Route::group(['prefix' => 'todo-lists', 'as' => 'todo-list.'], function () {
            Route::resource('', 'TodoListController')->parameters(['' => 'todo-list']);
            Route::delete('items/destroy', [
                'as'         => 'deletes',
                'uses'       => 'TodoListController@deletes',
                'permission' => 'todo-list.destroy',
            ]);
        });
    });

});
