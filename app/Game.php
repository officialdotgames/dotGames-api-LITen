<?php

namespace App;

use Illuminate\Database\Eloquent\Model;


class Game extends Model
{

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id', 'active', 'level'
    ];


    public function user() {
  		return $this->belongsTo('App\User', 'user_id');
  	}
}
