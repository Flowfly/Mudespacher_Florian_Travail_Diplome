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
    public function answeruser()
    {
        return $this->belongsTo('App\AnswserUser');
    }

}
