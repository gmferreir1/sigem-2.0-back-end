<?php

Route::group(['middleware' => ['auth:api'], 'prefix' => 'dead-file', 'namespace' => 'Modules\DeadFile\Http\Controllers'], function()
{
    Route::get('check-is-archived/{queryParams?}', 'DeadFileController@checkIsArchived');
    Route::get('years-available', 'DeadFileController@getYearsAvailable');
    Route::get('{queryParams?}', 'DeadFileController@all');
    Route::put('{id}', 'DeadFileController@cancelArchive');
    Route::post('', 'DeadFileController@save');
});
