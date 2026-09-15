<?php

namespace App\Models\Survey;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
   // use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
    ];


    public function questions()
    {
        return $this->hasMany(\App\Models\Survey\Question::class);
    }

    public function surveys()
    {
        return $this->hasMany(\App\Models\Survey\Survey::class);
    }
    public function microJobs()
    {
        return $this->hasMany(\App\Models\Survey\MicroJob::class);
    }
}
