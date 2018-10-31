<?php

/* **
 * Rotas do modulo imoveis captados
 * Route::immobile-captured
 */
Route::group(['middleware' => ['auth:api'], 'prefix' => 'immobile-captured', 'namespace' => 'Modules\ImmobileCaptured\Http\Controllers'], function()
{

    /* **
     * Route::immobile-captured/report-list
     */
    Route::group(['prefix' => 'report-list'], function () {
        Route::get('query-immobile-is-release/{queryParams?}', 'ReportListController@queryImmobileIsRelease');
        Route::get('query-responsible', 'ReportListController@queryResponsible');
        Route::post('', 'ReportListController@save');
        Route::put('{id}', 'ReportListController@update');
        Route::get('{id}', 'ReportListController@find');
        Route::get('{queryParams?}', 'ReportListController@all');
        Route::delete('{id}', 'ReportListController@delete');
    });
});
