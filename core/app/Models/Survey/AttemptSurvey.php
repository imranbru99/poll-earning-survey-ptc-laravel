<?php

namespace App\Models\Survey;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AttemptSurvey extends Model
{
    //use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'survey_question_id',
        'status',
        'user_id',
        'survey_id',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'user_id' => 'integer',
        'survey_question_id' => 'integer',
        'survey_id' => 'integer',
        'status' => 'boolean',
    ];

    public function takenBY()
    {
        return $this->belongsTo(\App\User::class);
    }

    public function survey()
    {
        return $this->belongsTo(\App\Models\Survey\Survey::class);
    }

    public function questions()
    {
        return $this->hasMnay(\App\Models\Survey\SurveyQuestion::class);
    }

    public function users()
    {
        return $this->hasMnay(\App\User::class);
    }
}
