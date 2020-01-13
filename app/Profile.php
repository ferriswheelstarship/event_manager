<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Profile extends Model
{
    protected $fillable = ['job', 'serial_number'];

    public function users(){
        return $this->hasOne('App\Profile');
    }
}
