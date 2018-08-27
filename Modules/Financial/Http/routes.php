<?php


/* ****
 * Rotas modulo financeiro
 * Route::financial
 */
Route::group(['middleware' => ['auth:api'], 'prefix' => 'financial', 'namespace' => 'Modules\Financial\Http\Controllers'], function()
{


    /* ***
     * Rotas contratos celebrados (financeiro)
     * Route::financial/contract-celebrated
     */

    Route::group(['prefix' => 'contract-celebrated'], function () {
        Route::get('', 'ContractCelebratedController@all');
        Route::post('', 'ContractCelebratedController@save');
    });

});
