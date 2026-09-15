<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use App\Models\Survey\AttemptSurvey;
use App\Models\Survey\UserMicroJob;
use App\Models\PtcView;
use App\Models\ComplatedSurvey;
use Cmgmyr\Messenger\Traits\Messagable;
use Cache;
class User extends Authenticatable
{
    use Notifiable;
    use Messagable;

    protected $fillable = [
        'microjob_id'
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */

    protected $guarded = ['id'];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'address' => 'object',
        'ver_code_send_at' => 'datetime'
    ];

    public function login_logs()
    {
        return $this->hasMany(App\Models\UserLogin::class);
    }

    public function transactions()
    {
        return $this->hasMany(App\Models\Transaction::class)->orderBy('id','desc');
    }

    public function deposits()
    {
        return $this->hasMany(App\Models\Deposit::class)->where('status','!=',0);
    }

    public function withdrawals()
    {
        return $this->hasMany(App\Models\Withdrawal::class)->where('status','!=',0);
    }

    public function plan()
    {
        return $this->belongsTo(App\Models\Plan::class);
    }

    public function clicks()
    {
        return $this->hasMany(App\Models\PtcView::class);
    }

    public function commissions()
    {
        return $this->hasMany(App\Models\CommissionLog::class);
    }


    public function refBy()
    {
        return $this->belongsTo(App\Models\User::class,'ref_by');
    }

    public function balance()
    {
        return $this->belongsTo(App\Models\User::class,'balance');
    }


    // SCOPES

    public function getFullnameAttribute()
    {
        return $this->firstname . ' ' . $this->lastname;
    }

    public function scopeActive()
    {
        return $this->where('status', 1);
    }

    public function scopeBanned()
    {
        return $this->where('status', 0);
    }

    public function scopeEmailUnverified()
    {
        return $this->where('ev', 0);
    }

    public function scopeSmsUnverified()
    {
        return $this->where('sv', 0);
    }
    public function scopeEmailVerified()
    {
        return $this->where('ev', 1);
    }

    public function scopeSmsVerified()
    {
        return $this->where('sv', 1);
    }

    public function surveys()
    {
        return $this->hasMany(App\Models\AttemptSurvey::class);
        //this ur IDE is too Dry
    }

        public function UserMicroJob()
    {
        return $this->hasMany(App\Models\UserMicroJob::class);
    }

      public function ComplatedSurvey()
    {
        return $this->hasMany(App\Models\ComplatedSurvey::class);
        //this ur IDE is too Dry
    }


    public function isOnline()
    {
        return Cache::has('isOnline'. $this->id);
    }


       public function SupportTicket()
    {
        return $this->hasMany(App\Models\SupportTicket::class);
    }



}
