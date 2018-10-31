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
        Route::get('last-attendance', 'TransferScoreAttendantController@getLastAttendance');
    });


    /* ****
    * Rota motivos de transferencia
    *
    * Route::register/transfer/reason
    */
    Route::group(['prefix' => 'reason'], function () {
        Route::post('', 'TransferReasonController@save');
        Route::get('', 'TransferReasonController@all');
        Route::put('{id}', 'TransferReasonController@update');
        Route::delete('{id}', 'TransferReasonController@delete');
    });


    /* ****
    * Rota contratos transferencia
    *
    * Route::register/transfer/contract
    */
    Route::group(['prefix' => 'contract'], function () {
        Route::post('', 'TransferContractController@save');
        Route::get('{id}', 'TransferContractController@find');
        Route::get('{queryParams?}', 'TransferContractController@all');
        Route::put('{id}', 'TransferContractController@update');
        Route::delete('{id}', 'TransferContractController@delete');
    });


   /* ****
   * Rota consultas do modulo
   *
   * Route::register/transfer/query
   */
    Route::group(['prefix' => 'query'], function () {
       Route::get('contract-is-release/{queryParams?}', 'TransferContractController@queryContractIsRelease');
       Route::get('get-all-responsible', 'TransferContractController@getAllResponsible');
    });
});
