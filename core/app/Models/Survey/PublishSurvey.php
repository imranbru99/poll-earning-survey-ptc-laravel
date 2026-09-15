<?php

namespace App\Models\Survey;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PublishSurvey extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'survey_question_id',
        'question_id',
        'DateRollout',
        'isPublished',
        'DateTobeOnline',
        'RollOutBy',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'survey_question_id' => 'integer',
        'DateRollout' => 'datetime',
        'isPublished' => 'boolean',
        'DateTobeOnline' => 'datetime',
    ];


    public function surveyQuestions()
    {
        return $this->hasMany(\App\Models\Survey\SurveyQuestion::class);
    }

    public function surveyQuestion()
    {
        return $this->belongsTo(\App\Models\Survey\SurveyQuestion::class);
    }
}
