<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Group_user extends Model
{
    protected $fillable = [
        'group_id','user_id'
    ];

    public function group() {
      return $this->belongsTo('App\Group');
    }
    public function user() {
      return $this->belongsTo('App\User');
    }
    
}
