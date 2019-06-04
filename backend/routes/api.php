<?php

use Illuminate\Http\Request;


Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/users/add', 'UserController@submitAPI')->name('api_user_add');
Route::post('/users/delete', 'UserController@deleteAPI');

Route::get('/session/not-started-sessions', 'SessionController@getAllNotStartedSessions');
Route::get('/session/{session_id}', 'SessionController@getSessionInfos');

Route::get('/session/{session_id}/actual-question', 'SessionController@getActualQuestion');
Route::get('/session/{session_id}/start', 'SessionController@startSessionAPI');
Route::get('/session/{session_id}/ranking', 'SessionController@getRankingAPI');
Route::get('/session/{session_id}/did-all-users-answered', 'AnswerController@didAllUsersAnswered');
Route::get('/session/{session_id}/{user_id}/ranking', 'SessionController@getUserRanking');


Route::post('/session/create', 'SessionController@createSession');
Route::post('/session/subscribe-user', 'SessionController@subscribeUser');
Route::post('/session/{session_id}/next-question', 'SessionController@nextQuestion');
Route::post('/session/{session_id}/answer', 'AnswerController@answer');



