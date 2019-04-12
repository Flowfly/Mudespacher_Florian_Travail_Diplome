<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    protected $fillable = [
        'username', 'password', 'email', 'phone_number', 'name', 'surname', 'date_of_birth'
    ];

    public $timestamps = false;

    public function teams(){
        return $this->belongsToMany('App\Team', 'user_team');
    }
    public function sessions(){
        return $this->belongsToMany('App\Session', 'user_session')
            ->as('session');
    }
    public function answers(){
        return $this->hasMany('App\Answer');
    }

}
