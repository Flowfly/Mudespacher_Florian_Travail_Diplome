<?php
/* Florian Mudespacher
 * Quiz interactif - Diploma work
 * CFPT - T.IS-E2A - 2019
 */

namespace App;

use Illuminate\Database\Eloquent\Model;

class Answer extends Model
{
    protected $fillable = [
      'user_id',
      'question_id',
      'proposition_id',
      'session_id',
      'datetime_answered',
    ];
    public $timestamps = false;

    public function user(){
        return $this->belongsTo('App\User');
    }

    public function question(){
        return $this->belongsTo('App\Question');
    }

    public function proposition(){
        return $this->belongsTo('App\Proposition');
    }

    public function session(){
        return $this->belongsTo('App\Session');
    }

}
