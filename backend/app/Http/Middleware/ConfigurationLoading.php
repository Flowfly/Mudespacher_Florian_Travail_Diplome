<?php

namespace App\Http\Middleware;

use App\Configuration;
use Closure;
use Illuminate\Support\Facades\Config;

class ConfigurationLoading
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        Config::set('constants.propositions.MINIMUM_PROPOSITION_LABEL_LENGTH', Configuration::where('name', '=', 'minimum_proposition_label_length')->firstOrFail()->value);
        Config::set('constants.propositions.MAXIMUM_PROPOSITION_LABEL_LENGTH', Configuration::where('name', '=', 'maximum_proposition_label_length')->firstOrFail()->value);

        Config::set('constants.questions.MINIMUM_QUESTION_LABEL_LENGTH', Configuration::where('name', '=', 'minimum_question_label_length')->firstOrFail()->value);
        Config::set('constants.questions.MAXIMUM_QUESTION_LABEL_LENGTH', Configuration::where('name', '=', 'maximum_question_label_length')->firstOrFail()->value);
        Config::set('constants.questions.MINIMUM_QUESTION_POINTS', Configuration::where('name', '=', 'minimum_question_points')->firstOrFail()->value);
        Config::set('constants.questions.MAXIMUM_QUESTION_POINTS', Configuration::where('name', '=', 'maximum_question_points')->firstOrFail()->value);

        Config::set('constants.sessions.NUMBER_OF_ASKED_QUESTION', Configuration::where('name', '=', 'number_of_asked_question')->firstOrFail()->value);
        Config::set('constants.sessions.NUMBER_OF_DISPLAYED_USERS', Configuration::where('name', '=', 'number_of_displayed_users')->firstOrFail()->value);
        Config::set('constants.sessions.MINIMUM_SESSION_LABEL_LENGTH', Configuration::where('name', '=', 'minimum_session_label_length')->firstOrFail()->value);
        Config::set('constants.sessions.MAXIMUM_SESSION_LABEL_LENGTH', Configuration::where('name', '=', 'maximum_session_label_length')->firstOrFail()->value);

        Config::set('constants.tags.MINIMUM_TAG_NAME_LENGTH', Configuration::where('name', '=', 'minimum_tag_name_length')->firstOrFail()->value);
        Config::set('constants.tags.MAXIMUM_TAG_NAME_LENGTH', Configuration::where('name', '=', 'maximum_tag_name_length')->firstOrFail()->value);

        Config::set('constants.teams.MINIMUM_TEAM_NAME_LENGTH', Configuration::where('name', '=', 'minimum_team_name_length')->firstOrFail()->value);
        Config::set('constants.teams.MAXIMUM_TEAM_NAME_LENGTH', Configuration::where('name', '=', 'maximum_team_name_length')->firstOrFail()->value);

        Config::set('constants.types.MINIMUM_TYPE_NAME_LENGTH', Configuration::where('name', '=', 'minimum_type_name_length')->firstOrFail()->value);
        Config::set('constants.types.MAXIMUM_TYPE_NAME_LENGTH', Configuration::where('name', '=', 'maximum_type_name_length')->firstOrFail()->value);

        Config::set('constants.users.MINIMUM_USERNAME_LENGTH', Configuration::where('name', '=', 'minimum_username_length')->firstOrFail()->value);
        Config::set('constants.users.MAXIMUM_USERNAME_LENGTH', Configuration::where('name', '=', 'maximum_username_length')->firstOrFail()->value);
        Config::set('constants.users.MINIMUM_PASSWORD_LENGTH', Configuration::where('name', '=', 'minimum_password_length')->firstOrFail()->value);
        Config::set('constants.users.MAXIMUM_PASSWORD_LENGTH', Configuration::where('name', '=', 'maximum_password_length')->firstOrFail()->value);
        Config::set('constants.users.MINIMUM_NAME_LENGTH', Configuration::where('name', '=', 'minimum_name_length')->firstOrFail()->value);
        Config::set('constants.users.MAXIMUM_NAME_LENGTH', Configuration::where('name', '=', 'maximum_name_length')->firstOrFail()->value);
        Config::set('constants.users.MINIMUM_SURNAME_LENGTH', Configuration::where('name', '=', 'minimum_surname_length')->firstOrFail()->value);
        Config::set('constants.users.MAXIMUM_SURNAME_LENGTH', Configuration::where('name', '=', 'maximum_surname_length')->firstOrFail()->value);
        return $next($request);
    }
}
