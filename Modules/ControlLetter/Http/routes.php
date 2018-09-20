<?php

Route::group(['middleware' => ['auth:api'], 'prefix' => 'control-letter', 'namespace' => 'Modules\ControlLetter\Http\Controllers'], function()
{
    Route::get('query-letters-registered', 'ControlLetterController@getLettersRegistered');
    Route::get('{id}', 'ControlLetterController@find');
    Route::put('{id}', 'ControlLetterController@update');
});
