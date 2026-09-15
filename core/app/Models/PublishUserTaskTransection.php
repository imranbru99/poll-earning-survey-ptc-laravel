<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PublishUserTaskTransection extends Model
{
    protected $table = 'publish_user_task_transections';

    protected $fillable = [
        'publisher_user_id',
        'username',
        'task_name',
        'task_type',
        'cost',
    ];
}
