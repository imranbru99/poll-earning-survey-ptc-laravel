<?php

namespace App;
use Illuminate\Database\Eloquent\Model;

class UserNotification extends Model
{
    use HasFactory;

    public function user()
    {
    	return $this->belongsTo(User::class);
    }
}
