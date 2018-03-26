<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Frame extends Model
{
    //

    protected $table = 'frames';
    protected $fillable = ['number', 'first_try', 'second_try','bonus_try', 'score', 'game_id'];

    public function game(){
        return $this->belongsTo('App\Game');
    }

    public function isStrike(){
        return $this->first_try == 10 ? true: false;
    }

    public function isSpread(){
        return $this->first_try + $this->second_try == 10 ? true: false;
    }

}
