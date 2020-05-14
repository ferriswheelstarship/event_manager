<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Group extends Model
{
    protected $fillable = [
        'name'
    ];

    public function mails() {
      return $this->hasMany('App\Email');
    }
    public function group_users() {
      return $this->hasMany('App\Group_user');
    }
}
