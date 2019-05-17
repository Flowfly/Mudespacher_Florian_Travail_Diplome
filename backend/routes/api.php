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

Route::get('/test', function () {
    return response()
        ->json(\App\Session::with('users')->get());

            /*\App\AnswerUser::query()
            ->select('propositions.label as proposition_label', 'questions.label as question_label', 'sessions.label as session_label', 'sessions.*', 'propositions.*', 'users.*', 'questions.*')
            ->join('propositions', 'answer_user.proposition_id', '=', 'propositions.id')
            ->join('questions', 'answer_user.proposition_id', '=', 'questions.id')
            ->join('users', 'answer_user.user_id', '=', 'users.id')
            ->join('sessions', 'answer_user.session_id', '=', 'sessions.id')
            ->get());*/
});

Route::post('/session/create', 'SessionController@createSession');
Route::post('/session/subscribe-user', 'SessionController@subscribeUser');
Route::post('/session/{session_id}/next-question', 'SessionController@nextQuestion');
Route::post('/session/{session_id}/answer', 'AnswerController@answer');



