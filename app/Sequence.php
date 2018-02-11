<?php

namespace App;

use Illuminate\Database\Eloquent\Model;


class Sequence extends Model
{

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'level', 'game_id', 'order', 'color_id'
    ];


    public function game() {
  		return $this->belongsTo('App\Game', 'game_id');
  	}

    public function color() {
      return $this->belongsTo('App\Color', 'color_id');
    }
}
