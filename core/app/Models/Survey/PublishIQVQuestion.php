<?php

namespace App\Models\Survey;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PublishIQVQuestion extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'IQVQuestion_id',
        'IQVTest_id',
        'DateRollout',
        'RollOutBy',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'IQVQuestion_id' => 'integer',
        'DateRollout' => 'datetime',
    ];


    public function iQVQuestion()
    {
        return $this->belongsTo(\App\Models\Survey\IQVQuestion::class);
    }
}
