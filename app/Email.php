<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Email extends Model
{
    protected $fillable = [
        'title','comment',
        'default_group','group_id','status'
    ];

    public function group() {
      return $this->belongsTo('App\Group');
    }
}
