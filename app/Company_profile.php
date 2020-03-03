<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Company_profile extends Model
{
    protected $fillable = 
                        [
                            'area_name', 'branch_name','company_variation',
                            'public_or_private','category','fax','kyokai_number'
                        ];

    public function users(){
        return $this->hasOne('App\User');
    }
}
