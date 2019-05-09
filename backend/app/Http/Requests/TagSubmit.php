<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Config;

class TagSubmit extends FormRequest
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
            'tag_name' => ['required', 'min:' . Config::get('constants.tags.MINIMUM_TAG_NAME_LENGTH'), 'max:' . Config::get('constants.tags.MAXIMUM_TAG_NAME_LENGTH')],
        ];
    }
}
