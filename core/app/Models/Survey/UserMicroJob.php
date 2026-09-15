<?php

namespace App\Models\Survey;

use Illuminate\Database\Eloquent\Model;

class UserMicroJob extends Model
{
    protected $table = "user_microjobs";
    use \Illuminate\Database\Eloquent\SoftDeletes;
    protected $fillable = [
        'microjob_id',
        'user_id',
        'comment',
        'date',
        'image1',
        'image2',
        'image3',
        'image4',
        'is_pending',
    ];
    //
}
