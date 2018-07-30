<?php

Route::group(['middleware' => ['auth:api'], 'prefix' => 'user', 'namespace' => 'Modules\User\Http\Controllers'], function()
{
    Route::get('get-data-user-logged', 'UserController@getDataUserLogged');
});
