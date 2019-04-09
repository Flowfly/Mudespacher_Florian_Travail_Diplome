<?php

use Illuminate\Http\Request;


Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/session/{session_id}/actual-question', 'SessionController@getActualQuestion');
Route::get('/session/{session_id}', 'SessionController@getSessionInfos');
Route::get('/test', function () {
    return response()
        ->json(\App\AnswerUser::query()
            ->select('propositions.label as proposition_label', 'questions.label as question_label', 'sessions.label as session_label', 'sessions.*', 'propositions.*', 'users.*', 'questions.*')
            ->join('propositions', 'answer_user.proposition_id', '=', 'propositions.id')
            ->join('questions', 'answer_user.proposition_id', '=', 'questions.id')
            ->join('users', 'answer_user.user_id', '=', 'users.id')
            ->join('sessions', 'answer_user.session_id', '=', 'sessions.id')
            ->get());
});

Route::post('/session/{session_id}/next-question', 'SessionController@nextQuestion');
Route::post('/session/{session_id}/answer', 'SessionController@answer');
Route::post('/session/start', 'SessionController@startSession');

Route::post('/users/add', 'UserController@submit')->name('api_user_add');
