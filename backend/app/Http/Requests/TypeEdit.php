<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Config;

class TypeEdit extends FormRequest
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
            'name' => ['required', 'min:' . Config::get('constants.types.MINIMUM_TYPE_NAME_LENGTH'), 'max:' . Config::get('constants.types.MAXIMUM_TYPE_NAME_LENGTH')],
        ];
    }
}
