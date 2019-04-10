<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserEdit extends FormRequest
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
            'username' => ['required', 'min:4', 'max:15', 'string'],
            'password' => ['nullable', 'min:5', 'max:20', 'confirmed'],
            'email' => ['email', 'nullable'],
            'phone' => ['string', 'nullable'],
            'name' => ['min:2', 'max:30', 'string', 'nullable'],
            'surname' => ['min:2', 'max:30', 'string', 'nullable'],
            'date' => ['date', 'nullable']
        ];
    }
}
