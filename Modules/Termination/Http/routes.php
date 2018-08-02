<?php

/****
 * Route::termination
 */
Route::group(['middleware' => ['auth:api'], 'prefix' => 'termination', 'namespace' => 'Modules\Termination\Http\Controllers'], function()
{

    /****
     * Route::termination/contract
     * Modulo contrato
     */
    Route::group(['prefix' => 'contract'], function () {

    });


    /***
     * Route::termination/destination-or-reason
     */
    Route::group(['prefix' => 'destination-or-reason'], function () {
        Route::post('', 'DestinationOrReasonController@create');
        Route::get('', 'DestinationOrReasonController@all');
        Route::put('{id}', 'DestinationOrReasonController@update');
    });



    /****
     * Route::termination/query
     * Consultas diversas
     */
    Route::group(['prefix' => 'query'], function () {

    });

});
