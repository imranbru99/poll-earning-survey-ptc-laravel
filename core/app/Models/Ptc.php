<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Ptc extends Model
{
    protected $guarded = ['id'];
    public function user()
    {
        return $this->belongsTo(App\Models\User::class);
    }

     public function ptc()
    {
        return $this->belongsTo(App\Models\Ptc::class);
}
}
