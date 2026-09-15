<?php

namespace App;

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
        return $this->belongsTo(User::class);
    }

    public function publish_user()
    {
        return $this->belongsTo(PublisherUser::class,'publisher_user_id','id');
    }

    public function supportMessage(){
        return $this->hasMany(SupportMessage::class);
    }

}
