<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PublishUserChangePassword extends Model
{
    protected $table = 'publisher_user_password_resets';

    protected $fillable = [
        'email',
        'token',
        'created_at'
    ];
}
