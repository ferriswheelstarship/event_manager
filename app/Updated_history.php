<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Updated_history extends Model
{
    protected $fillable = [
        'user_id', 'history_group_id', 'item_name',
        'before','after',
    ];

    public function user(){
        return $this->belongsTo('App\User');
    }

}
