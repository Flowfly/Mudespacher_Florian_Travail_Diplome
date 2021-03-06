@extends('backoffice/layout')
@section('content')
    <form class="form-group" action="/backoffice/update-config" method="post">
        <div class="row" style="text-align: center;">

            @csrf
            <div class="col-12" id="update-btn">
                @if(session('result'))
                    @if(session('result') == 1)
                        <div class="alert alert-success animated bounceInRight">
                            {{session('message')}}
                        </div>
                    @endif
                @endif
                <button class="btn btn-primary" style="width:100%; margin-bottom: 1%;">Mettre à jour</button>
            </div>
            <div class="col-12 configuration-title">
                <h2>Catégories</h2>
                <hr>
            </div>
            <div class="col-3 configuration-text">
                <p>Nombre de caractères minimum pour le nom :</p>
            </div>
            <div class="col-1">
                <input name="min_tag_name" type="number" min="0" class="form-control" style="text-align: center;"
                       value="{{\Illuminate\Support\Facades\Config::get('constants.tags.MINIMUM_TAG_NAME_LENGTH')}}">
            </div>

            <!----------------------------------------------->
            <div class="col-3 configuration-text">
                <p>Nombre de caractères maximum pour le nom :</p>
            </div>
            <div class="col-1">
                <input name="max_tag_name" type="number" min="0" class="form-control" style="text-align: center;"
                       value="{{\Illuminate\Support\Facades\Config::get('constants.tags.MAXIMUM_TAG_NAME_LENGTH')}}">
            </div>
            <div class="col">
                <p>-</p>
            </div>
            <div class="col-12 configuration-title">
                <h2>Équipes</h2>
                <hr>
            </div>
            <div class="col-3 configuration-text">
                <p>Nombre de caractères minimum pour le nom :</p>
            </div>
            <div class="col-1">
                <input name="min_team_name" type="number" min="0" class="form-control" style="text-align: center;"
                       value="{{\Illuminate\Support\Facades\Config::get('constants.teams.MINIMUM_TEAM_NAME_LENGTH')}}">
            </div>

            <!----------------------------------------------->
            <div class="col-3 configuration-text">
                <p>Nombre de caractères maximum pour le nom :</p>
            </div>
            <div class="col-1">
                <input name="max_team_name" type="number" min="0" class="form-control" style="text-align: center;"
                       value="{{\Illuminate\Support\Facades\Config::get('constants.teams.MAXIMUM_TEAM_NAME_LENGTH')}}">
            </div>
            <div class="col">
                <p>-</p>
            </div>
            <div class="col-12 configuration-title">
                <h2>Propositions</h2>
                <hr>
            </div>
            <!----------------------------------------------->
            <div class="col-3 configuration-text">
                <p>Nombre de caractères minimum pour le libellé :</p>
            </div>
            <div class="col-1">
                <input name="min_prop_name" type="number" min="0" class="form-control" style="text-align: center;"
                       value="{{\Illuminate\Support\Facades\Config::get('constants.propositions.MINIMUM_PROPOSITION_LABEL_LENGTH')}}">
            </div>
            <!----------------------------------------------->
            <div class="col-3 configuration-text">
                <p>Nombre de caractères maximum pour le libellé :</p>
            </div>
            <div class="col-1">
                <input name="max_prop_name" type="number" min="0" class="form-control" style="text-align: center;"
                       value="{{\Illuminate\Support\Facades\Config::get('constants.propositions.MAXIMUM_PROPOSITION_LABEL_LENGTH')}}">
            </div>
            <div class="col"><p>-</p></div>
            <div class="col-12 configuration-title">
                <h2>Questions</h2>
                <hr>
            </div>
            <!----------------------------------------------->
            <div class="col-3 configuration-text">
                <p>Nombre de caractères minimum pour le libellé :</p>
            </div>
            <div class="col-1">
                <input name="min_question_name" type="number" min="0" class="form-control" style="text-align: center;"
                       value="{{\Illuminate\Support\Facades\Config::get('constants.questions.MINIMUM_QUESTION_LABEL_LENGTH')}}">
            </div>
            <!----------------------------------------------->
            <div class="col-3 configuration-text">
                <p>Nombre de caractères maximum pour le libellé :</p>
            </div>
            <div class="col-1">
                <input name="max_question_name" type="number" min="0" class="form-control" style="text-align: center;"
                       value="{{\Illuminate\Support\Facades\Config::get('constants.questions.MAXIMUM_QUESTION_LABEL_LENGTH')}}">
            </div>
            <!----------------------------------------------->
            <div class="col-3 configuration-text">
                <p>Nombre de points minimum :</p>
            </div>
            <div class="col-1">
                <input name="min_question_points" type="number" min="0" class="form-control" style="text-align: center;"
                       value="{{\Illuminate\Support\Facades\Config::get('constants.questions.MINIMUM_QUESTION_POINTS')}}">
            </div>
            <!----------------------------------------------->
            <div class="col-3 configuration-text">
                <p>Nombre de points maximum :</p>
            </div>
            <div class="col-1">
                <input name="max_question_points" type="number" min="0" class="form-control" style="text-align: center;"
                       value="{{\Illuminate\Support\Facades\Config::get('constants.questions.MAXIMUM_QUESTION_POINTS')}}">
            </div>
            <div class="col-12 configuration-title">
                <h2>Quiz</h2>
                <hr>
            </div>
            <!----------------------------------------------->
            <div class="col-3 configuration-text">
                <p>Nombre de questions posées :</p>
            </div>
            <div class="col-1">
                <input name="number_of_asked_question" type="number" min="0" class="form-control"
                       style="text-align: center;"
                       value="{{\Illuminate\Support\Facades\Config::get('constants.sessions.NUMBER_OF_ASKED_QUESTION')}}">
            </div>
            <!----------------------------------------------->
            <div class="col-3 configuration-text">
                <p>Nombre d'utilisateurs affichés dans le classement :</p>
            </div>
            <div class="col-1">
                <input name="number_of_displayed_users" type="number" min="0" class="form-control"
                       style="text-align: center;"
                       value="{{\Illuminate\Support\Facades\Config::get('constants.sessions.NUMBER_OF_DISPLAYED_USERS')}}">
            </div>
            <div class="col"></div>
            <div class="col-12 configuration-title">
                <h2>Sessions</h2>
                <hr>
            </div>
            <!----------------------------------------------->
            <div class="col-3 configuration-text">
                <p>Nombre de caractères minimum pour le libellé :</p>
            </div>
            <div class="col-1">
                <input name="min_session_name" type="number" min="0" class="form-control" style="text-align: center;"
                       value="{{\Illuminate\Support\Facades\Config::get('constants.sessions.MINIMUM_SESSION_LABEL_LENGTH')}}">
            </div>
            <!----------------------------------------------->
            <div class="col-3 configuration-text">
                <p>Nombre de caractères maximum pour le libellé :</p>
            </div>
            <div class="col-1">
                <input name="max_session_name" type="number" min="0" class="form-control" style="text-align: center;"
                       value="{{\Illuminate\Support\Facades\Config::get('constants.sessions.MAXIMUM_SESSION_LABEL_LENGTH')}}">
            </div>
            <div class="col"></div>
            <div class="col-12 configuration-title">
                <h2>Types</h2>
                <hr>
            </div>
            <div class="col-3 configuration-text">
                <p>Nombre de caractères minimum pour le nom :</p>
            </div>
            <div class="col-1">
                <input name="min_type_name" type="number" min="0" class="form-control" style="text-align: center;"
                       value="{{\Illuminate\Support\Facades\Config::get('constants.types.MINIMUM_TYPE_NAME_LENGTH')}}">
            </div>

            <!----------------------------------------------->
            <div class="col-3 configuration-text">
                <p>Nombre de caractères maximum pour le nom :</p>
            </div>
            <div class="col-1">
                <input name="max_type_name" type="number" min="0" class="form-control" style="text-align: center;"
                       value="{{\Illuminate\Support\Facades\Config::get('constants.types.MAXIMUM_TYPE_NAME_LENGTH')}}">
            </div>
            <div class="col"></div>
            <div class="col-12 configuration-title">
                <h2>Utilisateurs</h2>
                <hr>
            </div>
            <!----------------------------------------------->
            <div class="col-3 configuration-text">
                <p>Nombre de caractères minimum pour le nom d'utilisateur :</p>
            </div>
            <div class="col-1">
                <input name="min_user_username" type="number" min="0" class="form-control" style="text-align: center;"
                       value="{{\Illuminate\Support\Facades\Config::get('constants.users.MINIMUM_USERNAME_LENGTH')}}">
            </div>

            <!----------------------------------------------->
            <div class="col-3 configuration-text">
                <p>Nombre de caractères maximum pour le nom d'utilisateur :</p>
            </div>
            <div class="col-1">
                <input name="max_user_username" type="number" min="0" class="form-control" style="text-align: center;"
                       value="{{\Illuminate\Support\Facades\Config::get('constants.users.MAXIMUM_USERNAME_LENGTH')}}">
            </div>
            <!----------------------------------------------->
            <div class="col-3 configuration-text">
                <p>Nombre de caractères minimum pour le mot de passe :</p>
            </div>
            <div class="col-1">
                <input name="min_user_password" type="number" min="0" class="form-control" style="text-align: center;"
                       value="{{\Illuminate\Support\Facades\Config::get('constants.users.MINIMUM_PASSWORD_LENGTH')}}">
            </div>

            <!----------------------------------------------->
            <div class="col-3 configuration-text">
                <p>Nombre de caractères maximum pour le mot de passe :</p>
            </div>
            <div class="col-1">
                <input name="max_user_password" type="number" min="0" class="form-control" style="text-align: center;"
                       value="{{\Illuminate\Support\Facades\Config::get('constants.users.MAXIMUM_PASSWORD_LENGTH')}}">
            </div>
            <!----------------------------------------------->
            <div class="col-3 configuration-text">
                <p>Nombre de caractères minimum pour le prénom :</p>
            </div>
            <div class="col-1">
                <input name="min_user_name" type="number" min="0" class="form-control" style="text-align: center;"
                       value="{{\Illuminate\Support\Facades\Config::get('constants.users.MINIMUM_NAME_LENGTH')}}">
            </div>

            <!----------------------------------------------->
            <div class="col-3 configuration-text">
                <p>Nombre de caractères maximum pour le prénom :</p>
            </div>
            <div class="col-1">
                <input name="max_user_name" type="number" min="0" class="form-control" style="text-align: center;"
                       value="{{\Illuminate\Support\Facades\Config::get('constants.users.MAXIMUM_NAME_LENGTH')}}">
            </div>
            <!----------------------------------------------->
            <div class="col-3 configuration-text">
                <p>Nombre de caractères minimum pour le nom :</p>
            </div>
            <div class="col-1">
                <input name="min_user_surname" type="number" min="0" class="form-control" style="text-align: center;"
                       value="{{\Illuminate\Support\Facades\Config::get('constants.users.MINIMUM_SURNAME_LENGTH')}}">
            </div>

            <!----------------------------------------------->
            <div class="col-3 configuration-text">
                <p>Nombre de caractères maximum pour le nom :</p>
            </div>
            <div class="col-1">
                <input name="max_user_surname" type="number" min="0" class="form-control" style="text-align: center;"
                       value="{{\Illuminate\Support\Facades\Config::get('constants.users.MAXIMUM_SURNAME_LENGTH')}}">
            </div>
            <div class="col"></div>
        </div>
    </form>
@endsection