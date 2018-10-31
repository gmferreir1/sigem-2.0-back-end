<?php

/* *
 * Route::system-alert
 */

Route::group(['middleware' => ['auth:api'], 'prefix' => 'system-alert', 'namespace' => 'Modules\SystemAlert\Http\Controllers'], function()
{
    Route::put('{id}', 'SystemAlertController@markRead');
    Route::get('find/{queryParams?}', 'SystemAlertController@find');


    Route::group(['prefix' => 'real-time'], function () {
        Route::get('check-messages/{user_id}', 'SystemAlertController@checkMessages');
    });
});
