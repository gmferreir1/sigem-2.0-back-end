<?php

Route::group(['middleware' => ['auth:api'], 'prefix' => 'manager-action', 'namespace' => 'Modules\ManagerAction\Http\Controllers'], function()
{

    Route::group(['prefix' => 'show-tables-updated'], function () {
        Route::get('', 'ManagerActionController@showTablesUpdated');
        Route::get('total-tables-updated', 'ManagerActionController@getTotalTablesUpdated');
    });

});
