<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AnswerUser extends Model
{
    protected $fillable = [
        'user_id',
        'question_id',
        'proposition_id',
        'session_id',
        'datetime_answered',
    ];

    protected $table = 'answer_user';

    public $timestamps = false;

    public function users(){
        return $this->hasMany('App\User');
    }

    public function questions(){
        return $this->hasMany('App\Question');
    }

    public function propositions(){
        return $this->hasMany('App\Proposition');
    }

    public function sessions(){
        return $this->hasMany('App\Session');
    }
}
