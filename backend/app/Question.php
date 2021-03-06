<?php
/* Florian Mudespacher
 * Quiz interactif - Diploma work
 * CFPT - T.IS-E2A - 2019
 */

namespace App;

use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    protected $fillable = [
        'label',
        'points',
        'type_id',
        'tag_id',
    ];

    public $timestamps = false;

    public function tag()
    {
        return $this->belongsTo('App\Tag');
    }

    public function type()
    {
        return $this->belongsTo('App\Type');
    }
    public function propositions(){
        return $this->hasMany('App\Proposition');
    }
    public function sessions(){
        return $this->hasMany('App\Session');
    }

    public function answers(){
        return $this->hasMany('App\Answer');
    }
}
