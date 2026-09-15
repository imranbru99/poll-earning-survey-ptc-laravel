<?php

namespace App\Models\Survey;

use Illuminate\Database\Eloquent\Model;

class MicroJobAttachment extends Model
{
    protected $table = "microjob_attachments";


    protected $fillable = [
        'user_microjob_id',
        'image',
    ];

}
