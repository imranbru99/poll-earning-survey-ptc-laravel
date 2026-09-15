<?php

namespace App\Models\Survey;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class IQVQuestion extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'IQVTest_id',
        'category_id',
        'question',
        'optionA',
        'optionB',
        'optionC',
        'optionD',
        'optionE',
        'optionF',
        'isAnswer',
        'point',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'IQVTest_id' => 'integer',
        'category_id' => 'integer',
        'isAnswer' => 'boolean',
    ];


    public function iQVTest()
    {
        return $this->belongsTo(\App\Models\Survey\IQVTest::class);
    }

    public function category()
    {
        return $this->belongsTo(\App\Models\Survey\Category::class);
    }
}
