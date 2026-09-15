<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PublisherUser extends Model
{

    protected $fillable = [
        'mobile',
        'firstname',
        'lastname',
        'email',
        'address',
        'status'
    ];

    protected $casts = [
        'address' => 'object',
        'email_verified_at' => 'datetime',
    ];


    public function deposits()
    {
        return $this->hasMany(App\Models\Deposit::class)->where('status','!=',0);
    }
}


