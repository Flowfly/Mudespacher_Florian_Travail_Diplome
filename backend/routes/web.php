<?php
/* Florian Mudespacher
 * Quiz interactif - Diploma work
 * CFPT - T.IS-E2A - 2019
 */

//<editor-fold desc=Quiz>


Route::post('backoffice/change-theme', 'BackofficeUserController@changeTheme');
Route::post('/backoffice/change-password', 'BackofficeUserController@changePassword');



Route::get('/backoffice', function () {
    $types = \App\Type::all();
    $tags = \App\Tag::all();
    return view('/backoffice/index', ['tags' => $tags, 'types' => $types]);
})->name('backoffice');
Route::get('/{session_id}', 'QuizController@index');
Route::get('/{session_id}/question', 'QuizController@question');
Route::get('/{session_id}/end', 'QuizController@end');
Route::post('/{session_id}', 'SessionController@startSessionQuiz');
//</editor-fold>
//<editor-fold desc=Backoffice>
//*************************************** Backoffice Users *************************************
//****** GET ******//
Route::get('/backoffice/login', 'BackofficeUserController@homeLogin');
Route::get('/backoffice/register', 'BackofficeUserController@homeRegister');
Route::get('/backoffice/logout', 'BackofficeUserController@logout');
Route::get('/backoffice/my-account', 'BackofficeUserController@myAccount');
//****** POST ******//
Route::post('/backoffice/login', 'BackofficeUserController@login');
Route::post('/backoffice/register', 'BackofficeUserController@register');
//**********************************************************************************************
//*************************************** Configuration *************************************
Route::get('/backoffice/configuration', 'ConfigurationController@index');

Route::post('/backoffice/update-config', 'ConfigurationController@update');
//**********************************************************************************************
//******************************************* Questions ****************************************
//****** GET ******//
Route::get('/backoffice/questions', 'QuestionController@getAll');
Route::get('/backoffice/questions/add', 'QuestionController@addGetInfos');
Route::get('/backoffice/questions/{id}', 'QuestionController@getOne');
Route::get('/backoffice/questions/edit/{id}', 'QuestionController@editGetInfos');
Route::get('/backoffice/questions/delete/{id}', 'QuestionController@delete');
//****** POST ******//
Route::post('backoffice/post-question', 'QuestionController@submit');
Route::post('backoffice/questions/edit/{id}/update', 'QuestionController@update');
//**********************************************************************************************


//****************************************** Propositions **************************************
//****** GET ******//
Route::get('/backoffice/propositions/read/{id}', 'PropositionController@getAllFromQuestion');
Route::get('/backoffice/propositions/delete/{id}', 'PropositionController@delete');
//****** POST ******//
//**********************************************************************************************
//******************************************** Sessions ****************************************
//****** GET ******//
Route::get('/backoffice/sessions/', 'SessionController@getAll');
Route::get('/backoffice/sessions/add', 'SessionController@addGetInfos');
Route::get('/backoffice/sessions/edit/{id}', 'SessionController@editGetInfos');
Route::get('/backoffice/sessions/{session_id}/restart', 'SessionController@restartSessionBackoffice');
Route::get('/backoffice/sessions/delete/{id}', 'SessionController@delete');
//****** POST ******//
Route::post('/backoffice/post-session', 'SessionController@submit');
Route::post('/backoffice/sessions/edit/{id}/update', 'SessionController@update');
//**********************************************************************************************
//********************************************** Tags ******************************************
//****** GET ******//
Route::get('/backoffice/tags/add', 'TagController@addGetInfos');
Route::get('/backoffice/tags', 'TagController@getAll');
Route::get('/backoffice/tags/edit/{id}', 'TagController@editGetInfos');
Route::get('/backoffice/tags/delete/{id}', 'TagController@delete');
Route::get('/backoffice/tags/{id}/questions', 'QuestionController@getAll')->name('tags_questions');
//****** POST ******//
Route::post('backoffice/post-tag', 'TagController@submit');
Route::post('backoffice/tags/edit/{id}/update', 'TagController@update');
//**********************************************************************************************

//********************************************** Teams *****************************************
//****** GET ******//
Route::get('/backoffice/teams/add', 'TeamController@addGetInfos');
Route::get('/backoffice/teams', 'TeamController@getAll');
Route::get('/backoffice/teams/edit/{id}', 'TeamController@editGetInfos');
Route::get('/backoffice/teams/delete/{id}', 'TeamController@delete');
Route::get('/backoffice/teams/user/delete/{id}', 'TeamController@deleteUser');
Route::get('/backoffice/teams/{id}/users', 'UserController@getAll')->name('team_users');
//****** POST ******//
Route::post('backoffice/post-team', 'TeamController@submit');
Route::post('backoffice/teams/edit/{id}/update', 'TeamController@update');
//**********************************************************************************************

//********************************************** Types *****************************************
//****** GET ******//
Route::get('/backoffice/types/add', 'TypeController@addGetInfos');
Route::get('/backoffice/types', 'TypeController@getAll');
Route::get('/backoffice/types/edit/{id}', 'TypeController@editGetInfos');
Route::get('/backoffice/types/delete/{id}', 'TypeController@delete');
Route::get('/backoffice/types/{id}/questions', 'QuestionController@getAll')->name('types_questions');
//****** POST ******//
Route::post('backoffice/post-type', 'TypeController@submit');
Route::post('backoffice/types/edit/{id}/update', 'TypeController@update');
//**********************************************************************************************

//********************************************** Users *****************************************
//****** GET ******//
Route::get('/backoffice/users/add', 'UserController@addGetInfos');
Route::get('/backoffice/users/add1', 'UserController@generate');
Route::get('/backoffice/users', 'UserController@getAll')->name("users_all");
Route::get('/backoffice/users/edit/{id}', 'UserController@editGetInfos');
Route::get('/backoffice/users/delete/{id}', 'UserController@delete');
Route::get('/backoffice/users/pdf/download', 'UserController@createPDF');
Route::get('/backoffice/users/pdf/result', 'UserController@pdfCanvas');
Route::get('/backoffice/users/{id}', 'UserController@getUserInfos');
//****** POST ******//
Route::post('backoffice/post-user', 'UserController@submit')->name('backoffice_user_add');
Route::post('backoffice/users/edit/{id}/update', 'UserController@update');
//**********************************************************************************************

//********************************************** Theme *****************************************
//****** GET ******//
Route::get('/backoffice/theme', 'ThemeController@index');
//****** POST ******//
Route::post('/backoffice/update-image', 'ThemeController@changeImage');
//**********************************************************************************************
//</editor-fold>

