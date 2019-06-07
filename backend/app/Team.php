<?php
/* Florian Mudespacher
 * Quiz interactif - Diploma work
 * CFPT - T.IS-E2A - 2019
 */

namespace App;

use Illuminate\Database\Eloquent\Model;

class Team extends Model
{
    protected $fillable = [
      'name',
    ];

    public $timestamps = false;

    public function users()
    {
        return $this->belongsToMany('App\User', 'user_team');
    }
}
