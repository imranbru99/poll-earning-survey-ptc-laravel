<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SupportTicket extends Model
{
    protected $guarded = ['id'];

    public function getUsernameAttribute()
    {
        return $this->name;
    }

    public function user()
    {
        return $this->belongsTo(App\Models\User::class);
    }

    public function publish_user()
    {
        return $this->belongsTo(App\Models\PublisherUser::class,'publisher_user_id','id');
    }

    public function supportMessage(){
        return $this->hasMany(App\Models\SupportMessage::class);
    }

}
