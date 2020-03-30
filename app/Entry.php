<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Entry extends Model
{
    protected $fillable = [
        'event_id','event_date_id','user_id','applying_user_id',
        'serial_number','entry_status','ticket_status','attend_status',
    ];

    public function user() {
      return $this->belongsTo('App\User');
    }
    public function event() {
      return $this->belongsTo('App\Event');
    }
    public function event_date() {
      return $this->belongsTo('App\Event_date');
    }

}
