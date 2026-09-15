<?php

namespace App\Models\Survey;

use App\Models\Survey\Category;
use Illuminate\Database\Eloquent\Model;
use App\Models\Survey\SurveyQuestion;
use App\Models\Survey\AttemptSurvey;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Survey extends Model
{
    //use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'category_id',
        'publisher_user_id',
        'name',
        'amount',
        'active',
        'description',
        'surveySlug',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'category_id' => 'integer',
    ];


    public function questions()
    {
        return $this->hasMany(SurveyQuestion::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    private function users()
    {
        return $this->belongsToMany(\App\User::class);
    }

    public function attempts()
    {
        return $this->hasMany(AttemptSurvey::class);
    }
}
