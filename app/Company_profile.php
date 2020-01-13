<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Company_profile extends Model
{
    protected $fillable = ['company_name', 'company_ruby'];

    public function users(){
        return $this->hasMany('App\Company_profile');
    }
}
