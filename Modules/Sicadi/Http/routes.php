<?php

Route::group(['middleware' => ['auth:api'], 'prefix' => 'sicadi', 'namespace' => 'Modules\Sicadi\Http\Controllers'], function()
{
    Route::post('upload-database', 'SicadiController@uploadDatabase');
    Route::get('read-file', 'SicadiController@readFile');


    /****
     * Route::sicadi/query
     */
    Route::group(['prefix' => 'query'], function () {
        Route::get('immobile-data/{queryParams?}', 'SicadiQueryController@queryImmobileData');
    });
});
