<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Registration_request extends Model
{
    protected $fillable = [
        'registration_type','reg_email','password','firstname', 'lastname', 'firstruby', 'lastruby',
        'phone','zip','address','birth_year','birth_month','birth_day',
        'company_profile_id','facility','other_facility_pref','other_facility_name','other_facility_address',
        'job','childminder_status','childminder_number_pref','childminder_number_only'
    ];
}
