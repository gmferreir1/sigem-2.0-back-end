<?php

Route::group(['middleware' => ['api'], 'prefix' => 'external-access', 'namespace' => 'Modules\ExternalAccess\Http\Controllers'], function()
{

    /* ****
     ** Recuperação de senha
     * Route::external-access/recovery-password
     */
    Route::group(['prefix' => 'recovery-password'], function () {
        Route::get('send-email', 'RecoveryPasswordController@sendEmail');
        Route::put('change-password', 'RecoveryPasswordController@changePassword');
    });
});
