<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Support\Facades\Config;

class SessionEdit extends FormRequest
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

    protected function failedValidation(Validator $validator)
    {
        if (self::route()->getPrefix() == "api")
            throw new HttpResponseException(response()->json($validator->errors(), 422));
        else {
            parent::failedValidation($validator);
        }
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'session_label' => ['required', 'min:' . Config::get('constants.sessions.MINIMUM_SESSION_LABEL_LENGTH'), 'max:' . Config::get('constants.sessions.MAXIMUM_SESSION_LABEL_LENGTH')],
            'tag' => ['required', 'numeric']
        ];
    }
}
