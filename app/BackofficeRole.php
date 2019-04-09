<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BackofficeRole extends Model
{
    public function backoffice_users()
    {
        return $this->hasMany('App\BackofficeUser');
    }
}
