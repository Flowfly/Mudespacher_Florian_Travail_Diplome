<?php
/* Florian Mudespacher
 * Quiz interactif - Diploma work
 * CFPT - T.IS-E2A - 2019
 */

namespace App;

use Illuminate\Database\Eloquent\Model;

class Proposition extends Model
{
    protected $fillable = [
        'label',
        'is_right_answer',
        'question_id',
    ];

    public $timestamps = false;

    public function question(){
        return $this->belongsTo('App\Question');
    }
    public function answers(){
        return $this->hasMany('App\Answer');
    }
}
