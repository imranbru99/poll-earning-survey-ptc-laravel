<?php

namespace App\Models\Survey;

use App\Models\Survey\SurveyQuestion;
// use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Pivot;

class Questionoption extends Pivot
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'survey_question_id',
		'option',		
		'isAnswer',
    ];

    protected $table='questionoptions';

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'survey_question_id' => 'integer',        
        'isAnswer' => 'boolean',        
    ];

    public $incrementing = true;


    public function survey_question()
    {
        return $this->belongsTo(SurveyQuestion::class, 'survey_question_id');
    }
}
