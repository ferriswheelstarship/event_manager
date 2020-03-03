<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Event_upload extends Model
{
    protected $fillable = ['event_id','path'];

    public function event() {
      return $this->belongsTo('App\Event');
    }
}
