<?php

/* ********
 * Modulo para dados do dashboard
 * Route::dashboard
 */

Route::group(['middleware' => ['auth:api'], 'prefix' => 'dashboard', 'namespace' => 'Modules\Dashboard\Http\Controllers'], function()
{

    /* ****
     * Route::dashboard/data-graph
     */
    Route::group(['prefix' => 'data-graph'], function () {
        Route::get('contracts-inactivated', 'DataGraphController@dataGraphContractInactivated');
        Route::get('contracts-celebrated/{queryParams?}', 'DataGraphController@dataGraphContractCelebrated');
        Route::get('contracts-celebrated-per-status', 'DataGraphController@dataGraphContractCelebratedPerStatus');
    });

});
