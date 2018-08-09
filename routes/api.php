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
