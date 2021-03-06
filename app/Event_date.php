<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Event_date extends Model
{
    protected $fillable = ['event_id','event_date'];
    
    public function event() {
      return $this->belongsTo('App\Event');
    }
    public function entrys() {
      return $this->hasMany('App\Entry');
    }
}
