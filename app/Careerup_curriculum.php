<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Careerup_curriculum extends Model
{
    protected $fillable = ['event_id','parent_curriculum','child_curriculum'];

    public function event() {
      return $this->belongsTo('App\Event');
    }
}
