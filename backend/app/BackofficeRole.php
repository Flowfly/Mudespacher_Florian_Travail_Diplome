<?php
/* Florian Mudespacher
 * Quiz interactif - Diploma work
 * CFPT - T.IS-E2A - 2019
 */

namespace App;

use Illuminate\Database\Eloquent\Model;

class BackofficeRole extends Model
{
    public function backoffice_users()
    {
        return $this->hasMany('App\BackofficeUser');
    }
}
