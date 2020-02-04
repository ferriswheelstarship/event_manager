<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Profile extends Model
{
    protected $fillable = ['job', 'serial_number','birth_year','birth_month','birth_day'];

    public function user(){
        return $this->hasOne('App\User');
    }
}
