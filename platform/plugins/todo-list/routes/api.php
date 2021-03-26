<?php

use App\Events\TodoCreated;
use Illuminate\Support\Facades\Route;

Route::group([
    'middleware' => 'api',
    'prefix' => 'api/v1',
    'namespace' => 'Platform\TodoList\Http\Controllers\API',
], function () {
    Route::group([
        'middleware' => ['auth:member-api']
    ], function () {
        Route::resource('todo', 'TodoListController')->except('create')->parameters('todo');
        Route::post('todo/bulk-delete', 'TodoListController@bulkDelete')->name('todo.bulkDelete');
        Route::get('socket-io/test', function () {
            broadcast(new TodoCreated());
            return "ok";
        });
    });
});
