<?php

namespace App\Http\Requests\Survey;

use Illuminate\Foundation\Http\FormRequest;

class SurveyQuestionStoreRequest extends FormRequest
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
            'survey_id' => ['integer', 'exists:surveys,id'],
            'question' => ['string'],
            'optionA' => ['string'],
            'optionB' => ['string'],
            'isAnswer' => [''],
        ];
    }
}
