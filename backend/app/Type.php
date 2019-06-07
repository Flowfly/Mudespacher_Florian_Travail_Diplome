<?php
/* Florian Mudespacher
 * Quiz interactif - Diploma work
 * CFPT - T.IS-E2A - 2019
 */

namespace App;

use Illuminate\Database\Eloquent\Model;

class Type extends Model
{
    protected $fillable = ['label'];

    public $timestamps = false;

    public function questions(){
        return $this->hasMany('App\Question');
    }
}
