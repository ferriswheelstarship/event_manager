<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Profile extends Model
{
    protected $fillable = 
    [
        'birth_year','birth_month','birth_day',
        'job','childminder_status','childminder_number',
        'other_facility_name','other_facility_pref','other_facility_address'
    ];

    public function user(){
        return $this->hasOne('App\User');
    }
}
