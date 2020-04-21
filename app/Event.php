<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class Event extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'general_or_carrerup','user_id','title','comment',
        'training_minute','capacity','place','notice'
    ];

    protected $dates = [
        'view_start_date','view_end_date','entry_start_date','entry_end_date'
    ];

    public function user() {
      return $this->belongsTo('App\User');
    }

    public function careerup_curriculums() {
      return $this->hasMany('App\Careerup_curriculum');
    }

    public function event_dates() {
      return $this->hasMany('App\Event_date');
    }

    public function event_uploads() {
      return $this->hasMany('App\Event_upload');
    }

    public function entrys() {
      return $this->hasMany('App\Entry');
    }

    public function Certificate() {
      return $this->hasOne('App\Certificate');
    }
}
