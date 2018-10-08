<?php
/* ****
 * Rotas do modulo Chat
 * Route::chat
 */

Route::group(['middleware' => ['auth:api'], 'prefix' => 'chat', 'namespace' => 'Modules\Chat\Http\Controllers'], function()
{

    /* ****
     * Rotas para transações do tipo (login, logout, checagem de interação do usuário)
     *
     * Route::chat/transaction-actions
     */
    Route::group(['prefix' => 'transaction-actions'], function () {

        Route::get('login', 'ChatController@login');
        Route::get('interaction-user', 'ChatController@setInteractionUserLogged');
        Route::get('logout', 'ChatController@logout');
        Route::get('all-users', 'ChatController@getAllUsers');
        Route::get('check-users-online', 'ChatController@checkUsersOnline');

    });


    /* ****
     * Route::chat/conversations
     */
    Route::group(['prefix' => 'conversations'], function () {
        Route::get('mark-read/{queryParams?}', 'ChatController@markMessageRead');
        Route::get('{queryParams?}', 'ChatController@getConversations');
        Route::post('', 'ChatController@save');
    });


   /* ****
    * Route::chat/real-time
    */
    Route::group(['prefix' => 'real-time'], function () {
        Route::get('shoot/{id_to}', 'ChatController@shootRealTime');
        Route::get('typing/{queryParams?}', 'ChatController@typing');
    });


});
