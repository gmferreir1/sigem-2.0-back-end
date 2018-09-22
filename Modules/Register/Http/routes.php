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
         * Score Atendimento
         *
         * Route::register/reserve-contract/score
         */
        Route::group(['prefix' => 'score'], function () {

            Route::get('', 'ScoreController@all');
            Route::post('', 'ScoreController@save');
            Route::put('{id}', 'ScoreController@update');
            Route::delete('{id}', 'ScoreController@delete');
            Route::get('next-attendance', 'ScoreController@getNextAttendance');

        });

        /* ****
        * Motivos cancelamento
        *
        * Route::register/reserve-contract/reason-cancel
        */
        Route::group(['prefix' => 'reason-cancel'], function () {

            Route::get('', 'ReasonCancelController@all');
            Route::post('', 'ReasonCancelController@save');
            Route::put('{id}', 'ReasonCancelController@update');
            Route::delete('{id}', 'ReasonCancelController@delete');
        });


       /* ****
        * Rota montagem emails para o proprietário, inquilino, condominio
        *
        * Route::register/reserve-contract/email-data
        */
        Route::get('email-data/{queryParams?}', 'ReserveContractController@emailData');


        /* ****
        * Rota reservas de contratos
        *
        * Route::register/reserve-contract
        */

        Route::get('printer/{queryParams?}', 'ReserveContractController@callPrinter');
        Route::post('', 'ReserveContractController@save');
        Route::put('{id}', 'ReserveContractController@update');
        Route::get('{id}', 'ReserveContractController@find');
        Route::get('{queryParams?}', 'ReserveContractController@all');


        /* ****
         * Rota de consultas extras
         *
         * Route::register/reserve-contract/query
         */
        Route::group(['prefix' => 'query'], function () {
            Route::get('client/{queryParams?}', 'ReserveContractController@getClient');
            Route::get('immobile-is-release/{queryParams?}', 'ReserveContractController@immobileIsRelease');
            Route::get('responsible-for-filter', 'ReserveContractController@getResponsibleForFilter');
            Route::get('check-contract-is-release/{queryParams?}', 'ReserveContractController@checkContractIsRelease');
            Route::get('get-years-available', 'ReserveContractController@getYearsAvailable');
            Route::get('email-letters/{reserve_id}', 'ReserveContractEmailController@queryEmailLetter');
        });


        /* ****
         * Rota de envio emails
         *
         * Route::register/reserve-contract/emails
         */
        Route::group(['prefix' => 'emails'], function () {
            Route::get('send-email-end-reserve/{queryParams?}', 'ReserveContractEmailController@sendEmailEndReserve');
            Route::get('send-email-letters/{queryParams?}', 'ReserveContractEmailController@sendEmailLetters');
        });

    });


});
