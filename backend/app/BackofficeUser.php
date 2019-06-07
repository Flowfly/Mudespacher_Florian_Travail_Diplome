<?php
/* Florian Mudespacher
 * Quiz interactif - Diploma work
 * CFPT - T.IS-E2A - 2019
 */

namespace App;

use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;

class BackofficeUser extends Model implements Authenticatable
{
    use \Illuminate\Auth\Authenticatable;
    protected $fillable = [
        'username',
        'password',
        'role_id'
    ];

    public $timestamps = false;

    public function backoffice_role(){
        return $this->belongsTo('App\BackofficeRole');
    }
}
