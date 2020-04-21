<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Certificate extends Model
{
    protected $fillable = [
        'user_id','event_id','certificate_status',
    ];

    public function user() {
      return $this->belongsTo('App\User');
    }

    public function event() {
      return $this->belongsTo('App\User');
    }
    
}
