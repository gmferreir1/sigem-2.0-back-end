<?php

Route::group(['middleware' => ['auth:api'], 'prefix' => 'system-goal', 'namespace' => 'Modules\SystemGoal\Http\Controllers'], function()
{
    Route::post('', 'SystemGoalController@save');
    Route::get('', 'SystemGoalController@all');
    Route::get('{id}', 'SystemGoalController@find');
    Route::put('{id}', 'SystemGoalController@update');
    Route::delete('{id}', 'SystemGoalController@delete');
});
