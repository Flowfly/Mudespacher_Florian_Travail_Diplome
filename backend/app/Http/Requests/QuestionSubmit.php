<?php

namespace App\Http\Requests;
use Illuminate\Http\Request;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Config;

class QuestionSubmit extends FormRequest
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
    public function rules(Request $request)
    {
        $rules = [
            'question_label' => ['min:' . Config::get('constants.questions.MINIMUM_QUESTION_LABEL_LENGTH'), 'max:' . Config::get('constants.questions.MAXIMUM_QUESTION_LABEL_LENGTH'), 'required', 'string', 'filled'],
            'question_points' => ['required', 'numeric', 'between:' . Config::get('constants.questions.MINIMUM_QUESTION_POINTS') . ',' . Config::get('constants.questions.MAXIMUM_QUESTION_POINTS')],
            'question_type' => ['required', 'numeric'],
            'question_tag' => ['required', 'numeric'],
            'isGoodAnswer' => ['required', 'numeric'],
        ];
        for ($i = 0; $i < count($request->all()); $i++) {
            $tmp = explode('-', $request->keys()[$i])[0];
            if ($tmp == 'prop') {
                $rules[$request->keys()[$i]] = ['min:' . Config::get('constants.propositions.MINIMUM_PROPOSITION_LABEL_LENGTH'), 'max:' . Config::get('constants.propositions.MAXIMUM_PROPOSITION_LABEL_LENGTH'), 'required', 'string', 'filled'];
            }

        }
        return $rules;
    }
}
