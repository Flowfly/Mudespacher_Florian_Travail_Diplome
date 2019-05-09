<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Config;

class TeamSubmit extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => ['min:' . Config::get('constants.teams.MINIMUM_TEAM_NAME_LENGTH'), 'max:' .  Config::get('constants.teams.MAXIMUM_TEAM_NAME_LENGTH'), 'required', 'string', 'unique:teams,name']
        ];
    }
}
