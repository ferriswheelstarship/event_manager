<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Event_date extends Model
{
    protected $fillable = ['event_id'];

    protected $dates = ['event_date'];
    
    public function event() {
      return $this->belongsTo('App\Event');
    }
}
