<?php

namespace App\Models\Survey;

use App\Models\Survey\Survey;
use App\Models\Survey\Category;
use App\Models\Survey\Questiontype;
use App\Models\Survey\Questionoption;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\User;
class SurveyQuestion extends Model
{
    //use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'category_id',
        'survey_id',
        'questiontype_id',
        'question',
        'isPublished',
        'isBeenAnswered',
        'link',
        'point',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'category_id' => 'integer',
        'survey_id' => 'integer',
        'questiontype_id' => 'integer',
        'isPublished' => 'boolean',
        'isBeenAnswered' => 'boolean',
    ];


    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function survey()
    {
        return $this->belongsTo(Survey::class);
    }

    public function type()
    {
        return $this->belongsTo(Questiontype::class);
    }

    /**
     * SurveyQuestion belongs to .
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function options()
    {
        // belongsTo(RelatedModel, foreignKey = _id, keyOnRelatedModel = id)
        return $this->hasMany(Questionoption::class);
    }

    /**
     * SurveyQuestion has many QuestionImages.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function questionImages()
    {
        // hasMany(RelatedModel, foreignKeyOnRelatedModel = survey_question_id, localKey = id)
        return $this->hasMany(Questionimage::class);
    }

    /**
     * SurveyQuestion has many QuestionValues.
     *
     * @return \Illuminate\Database\Eloquent\R0lations\HasMany
     */
    public function questionValues()
    {
        // hasMany(RelatedModel, foreignKeyOnRelatedModel = survey_question_id, localKey = id)
        return $this->hasMany(Questionvalue::class);
    }

    public function questionOptions()
    {
        return $this->hasMany(Questionoption::class);
    }

    /**
     * Get all of the users for the SurveyQuestion
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function users()
    {
        return $this->hasMany(User::class);
    }
}
