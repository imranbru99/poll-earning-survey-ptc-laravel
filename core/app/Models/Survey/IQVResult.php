<?php

namespace App\Models\Survey;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class IQVResult extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'AttemptBy',
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
        'AttemptBy' => 'integer',
        'dateAttempt' => 'datetime',
        'passStatus' => 'boolean',
    ];


    public function attemptBy()
    {
        return $this->belongsTo(\App\Models\Survey\AttemptBy::class);
    }
}
