<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PublishUserVerify extends Model
{
    protected $table = 'publish_user_verify';

    protected $fillable = [
        'user_id',
        'token',
    ];

    public function publishUser()
    {
        return $this->hasOne(PublisherUser::class,'id','user_id');
    }
}
