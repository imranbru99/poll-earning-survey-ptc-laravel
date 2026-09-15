<?php

namespace App\Models\Survey;

use Illuminate\Database\Eloquent\Model;

class MicroJob extends Model
{
    protected $table = "microjobs";
//    protected $dateFormat = 'U';
//    protected $casts = [
//        'created_at' => 'int',
//        'updated_at' => 'int',
//        'deleted_at' => 'int'
//    ];


    protected $fillable = [
        'publisher_user_id',
        'category_id',
        'title',
        'limit',
        'remaining_limit',
        'description',
        'set_of_jobs',
        'time',
        'amount',
        'status',
    ];
    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}
