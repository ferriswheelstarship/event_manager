<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use App\Notifications\PasswordResetNotification;
use Illuminate\Database\Eloquent\SoftDeletes;


class User extends Authenticatable
{
    use Notifiable;
    use SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'company_profile_id','profile_id',
        'ruby','phone','zip','address',
        'email_verified', 'email_verify_token',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];
    
    public function role(){
        return $this->belongsTo('App\Role');
    }
    public function profile(){
        return $this->belongsTo('App\Profile');
    }
    public function company_profile(){
        return $this->belongsTo('App\Company_profile');
    }
    public function events(){
        return $this->hasMany('App\Event');
    }
    public function entrys(){
        return $this->hasMany('App\Entry');
    }
    public function certificates(){
        return $this->hasMany('App\Certificate');
    }
    public function careerup_certificates(){
        return $this->hasMany('App\Careerup_Certificate');
    }
    public function group_users(){
        return $this->hasMany('App\Group_user');
    }
    public function updated_historys(){
        return $this->hasMany('App\Updated_history');
    }

    /**
     * パスワードリセット通知の送信をオーバーライド
     *
     * @param  string  $token
     * @return void
     */
    public function sendPasswordResetNotification($token)
    {
      $this->notify(new PasswordResetNotification($token));
    }    
}
