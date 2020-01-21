<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Profile extends Model
{
    protected $fillable = ['job', 'serial_number'];

    public function user(){
        return $this->hasOne('App\User');
    }
}
