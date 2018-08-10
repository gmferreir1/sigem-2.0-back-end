<?php

/****
 * Route::termination
 */
Route::group(['middleware' => ['auth:api'], 'prefix' => 'termination', 'namespace' => 'Modules\Termination\Http\Controllers'], function()
{

    /****
     * Route::termination/score
     * Score de atendimento
     */
    Route::group(['prefix' => 'score'], function () {
        Route::get('', 'ScoreController@all');
        Route::post('', 'ScoreController@create');
        Route::put('{id}', 'ScoreController@update');
        Route::delete('{id}', 'ScoreController@delete');
        Route::get('get-next-attendance', 'ScoreController@getNextAttendance');
    });


    /****
     * Route::termination/contract
     * Modulo contrato
     */
    Route::group(['prefix' => 'contract'], function () {
        Route::post('', 'ContractController@create');
        Route::put('{id}', 'ContractController@update');
        Route::get('get-all-responsible', 'ContractController@getAllResponsible');
        Route::get('{id}', 'ContractController@find');
        Route::get('{queryParams?}', 'ContractController@all');
        Route::get('{contract_id}/historic', 'ContractController@getHistoric');
    });


    /****
     * Route::termination/end-contract-in-lot
     * Baixa de contrato em lote
     */
    Route::group(['prefix' => 'end-contract-in-lot'], function () {
        Route::get('search-termination/{queryParams?}', 'ContractController@getContractPending');
        Route::put('', 'ContractController@endContractsLot');
    });



    /****
     * Route::termination/rent-accessory
     * Acessorios da locação
     */
    Route::group(['prefix' => 'rent-accessory'], function () {
        Route::get('{termination_id}', 'RentAccessoryController@find');
        Route::put('{id}', 'RentAccessoryController@update');
    });


    /***
     * Route::termination/destination-or-reason
     */
    Route::group(['prefix' => 'destination-or-reason'], function () {
        Route::post('', 'DestinationOrReasonController@create');
        Route::get('', 'DestinationOrReasonController@all');
        Route::put('{id}', 'DestinationOrReasonController@update');
        Route::delete('{id}', 'DestinationOrReasonController@remove');
    });



    /****
     * Route::termination/query
     * Consultas diversas
     */
    Route::group(['prefix' => 'query'], function () {
        Route::get('contract-already-release/{contract}', 'ContractController@checkContractAlreadyRelease');
        Route::get('guarantors/{queryParams?}', 'ContractController@getGuarantorsContract');
        Route::get('last-attendances', 'ContractController@getLastAttendances');
    });


    /****
     * Route::termination/record
     * Impressão de fichas
     */
    Route::group(['prefix' => 'record'], function () {
        Route::get('{queryParams?}', 'RecordPrinterController@printerRecord');
    });

});
