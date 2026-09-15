<?php

namespace App\Http\Requests\Survey;

use Illuminate\Foundation\Http\FormRequest;

class PublishIQVQuestionUpdateRequest extends FormRequest
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
            'IQVQuestion_id' => ['integer', 'exists:IQVQuestions,id'],
            'IQVTest_id' => ['integer'],
            'DateRollout' => [''],
            'RollOutBy' => ['integer'],
        ];
    }
}
