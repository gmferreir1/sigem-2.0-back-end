<?php

/* ****
* Rota modulo de transferencia
*
* Route::register/transfer
*/

Route::group(['middleware' => ['auth:api'], 'prefix' => 'register/transfer', 'namespace' => 'Modules\Register\Http\Controllers'], function()
{

    /* ****
    * Rota score atendimento da transferencia
    *
    * Route::register/transfer/score-attendant
    */
    Route::group(['prefix' => 'score-attendant'], function () {
        Route::post('', 'TransferScoreAttendantController@save');
        Route::get('', 'TransferScoreAttendantController@all');
        Route::put('{id}', 'TransferScoreAttendantController@update');
        Route::delete('{id}', 'TransferScoreAttendantController@delete');
    });
});
