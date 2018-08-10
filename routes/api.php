<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('query-cep/{cep}', function ($cep) {

    try {
        $url = file_get_contents("https://viacep.com.br/ws/$cep/json/");

        return $url;

    } catch (Exception $e) {
        return [
            'error' => true,
            'code' => $e->getCode()
        ];
    }
});


/**
 * Deleta um arquivo na pasta public
 */
Route::get('/remove-file/{params?}', function () {

    $params = [
        'file_name' => Request()->get('file_name')
    ];

    umask(0);

    unlink(public_path($params['file_name']));

});
