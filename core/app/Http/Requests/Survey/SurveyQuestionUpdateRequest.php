<?php

namespace App\Http\Requests\Survey;

use Illuminate\Foundation\Http\FormRequest;

class SurveyQuestionUpdateRequest extends FormRequest
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
            'category_id' => ['integer', 'exists:categories,id'],
            'survey_id' => ['integer', 'exists:surveys,id'],
            'question' => ['string'],
            'optionA' => ['string'],
            'optionB' => ['string'],
            'optionC' => ['string'],
            'optionD' => ['string'],
            'optionE' => ['string'],
            'optionF' => ['string'],
            'isAnswer' => [''],
            'isPublished' => [''],
            'isBeenAnswered' => [''],
            'point' => ['integer'],
        ];
    }
}
