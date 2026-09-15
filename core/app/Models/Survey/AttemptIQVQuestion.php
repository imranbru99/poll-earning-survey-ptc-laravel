<?php

namespace App\Models\Survey;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AttemptIQVQuestion extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'attemptBy',
        'IQVQuestion_id',
        'status',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'attemptBy' => 'integer',
        'IQVQuestion_id' => 'integer',
        'status' => 'boolean',
    ];


    public function publishIQVQuestions()
    {
        return $this->hasMany(\App\Models\Survey\PublishIQVQuestion::class);
    }

    public function iQVQuestions()
    {
        return $this->hasMany(\App\Models\Survey\IQVQuestion::class);
    }

    public function attemptBy()
    {
        return $this->belongsTo(\App\Models\Survey\AttemptBy::class);
    }

    public function iQVQuestion()
    {
        return $this->belongsTo(\App\Models\Survey\IQVQuestion::class);
    }
}
