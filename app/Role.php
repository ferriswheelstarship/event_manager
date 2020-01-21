<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    protected $fillable = ['level', 'display_name'];
    
    public function users(){
        return $this->hasMany('App\User');
    }
}
