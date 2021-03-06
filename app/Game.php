<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Game extends Model
{
    //
    protected $table = 'games';
    protected $fillable = ['name'];

    public function frames(){
        return $this->hasMany('App\Frame');
    }
}
