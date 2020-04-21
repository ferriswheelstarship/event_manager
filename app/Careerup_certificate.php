<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Careerup_certificate extends Model
{
    protected $fillable = [
        'user_id','parent_curriculum','certificate_status',
    ];

    public function user() {
      return $this->belongsTo('App\User');
    }
}
