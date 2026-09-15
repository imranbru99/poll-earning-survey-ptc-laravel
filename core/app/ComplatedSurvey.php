<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ComplatedSurvey extends Model
{
    protected $table = "completed_surveys";
    protected $fillable = [
        'user_id',
        'option',
        'survey_id',
        'is_correct',
        'created_at',
        'survey_question_id'
    ];
    //
}
