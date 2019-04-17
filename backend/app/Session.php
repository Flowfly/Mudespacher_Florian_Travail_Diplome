<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Session extends Model
{
    protected $fillable = [
        'label',
        'current_game_question',
        'question_id',
        'date_of_session'
    ];

    public $timestamps = false;

    public function question(){
        return $this->belongsTo('App\Question');
    }

    public function users(){
        return $this->belongsToMany('App\User', 'user_session');
    }

    public function answers(){
        return $this->hasMany('App\Answer');
    }

    public function tag(){
        return $this->belongsTo('App\Tag');
    }
}
