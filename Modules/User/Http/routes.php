<?php

Route::group(['middleware' => ['auth:api'], 'prefix' => 'user', 'namespace' => 'Modules\User\Http\Controllers'], function()
{
    Route::get('get-data-user-logged', 'UserController@getDataUserLogged');
    Route::post('', 'UserController@create');
    Route::get('{id}', 'UserController@find');
    Route::put('{id}', 'UserController@update');
    Route::get('{queryParams?}', 'UserController@all');



    Route::group(['prefix' => 'query-extra-module'], function () {
        Route::get('qtd-users-registered', 'UserController@getTotalUsersRegistered');
    });
});
