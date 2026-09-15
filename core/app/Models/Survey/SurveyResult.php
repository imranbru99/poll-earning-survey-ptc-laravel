<?php

namespace App\Models\Survey;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SurveyResult extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'attemptBY',
        'totalScoreObtained',
        'dateAttempt',
        'passStatus',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'attemptBY' => 'integer',
        'dateAttempt' => 'datetime',
        'passStatus' => 'boolean',
    ];


    public function attemptBY()
    {
        return $this->belongsTo(\App\Models\Survey\AttemptBY::class);
    }
}
