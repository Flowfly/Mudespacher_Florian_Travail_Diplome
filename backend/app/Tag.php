<?php
/* Florian Mudespacher
 * Quiz interactif - Diploma work
 * CFPT - T.IS-E2A - 2019
 */

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    protected $fillable = ['label'];

    public $timestamps = false;

    public function questions(){
        return $this->hasMany('App\Question');
    }
    public function sessions(){
        return $this->hasMany('App\Session');
    }
}
