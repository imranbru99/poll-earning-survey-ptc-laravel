<?php

namespace App\Models\Survey;

use Illuminate\Database\Eloquent\Model;

class Questionvalue extends Model
{
    /**
     * Fields that can be mass assigned.
     *
     * @var array
     */
    protected $fillable = [
    	'survey_question_id',
		'MinVal',
		'MaxVal',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'MinVal' => 'integer',
        'MaxVal' => 'integer',
    ];

    /**
     * Questionvalue belongs to SurveyQuestion.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function surveyQuestion()
    {
    	// belongsTo(RelatedModel, foreignKey = survey_question_id, keyOnRelatedModel = id)
    	return $this->belongsTo(SurveyQuestion::class, 'survey_question_id');
    }
}
