<?php

/* ****
* Rota de consultas extras
*
* Route::register
*/

Route::group(['middleware' => ['auth:api'], 'prefix' => 'register', 'namespace' => 'Modules\Register\Http\Controllers'], function()
{

    /* ****
    * Rota de consultas extras
    *
    * Route::register/reserve-contract
    */
    Route::group(['prefix' => 'reserve-contract'], function () {


        /* ****
         * Rota de consultas extras
         *
         * Route::register/reserve-contract/query
         */
        Route::group(['prefix' => 'query'], function () {
            Route::get('client/{queryParams?}', 'ReserveContractController@getClient');
            Route::get('immobile-is-release/{queryParams?}', 'ReserveContractController@immobileIsRelease');
        });


        /* ****
         * Score Atendimento
         *
         * Route::register/reserve-contract/score
         */
        Route::group(['prefix' => 'score'], function () {

            Route::get('', 'ScoreController@all');
            Route::post('', 'ScoreController@save');
            Route::put('{id}', 'ScoreController@update');
            Route::delete('{id}', 'ScoreController@delete');

        });

    });


});
