<?php


use Illuminate\Support\Facades\Route;

Route::group([
    'middleware' => 'api',
    'prefix' => 'api/v1',
    'namespace' => 'Platform\SpendingDiary\Http\Controllers\API',
], function () {
    Route::group([
        'middleware' => ['auth:member-api']
    ], function () {
        Route::resource('diary', 'SpendingDiaryController')->except('create')->parameters('diary');
        Route::post('diary/bulk-delete', 'SpendingDiaryController@bulkDelete')->name('diary.bulkDelete');
        Route::get('diary-categories', 'SpendingDiaryController@getCategories')->name('diary.categories');
    });
});
