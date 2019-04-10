<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    protected $fillable = ['label'];

    public $timestamps = false;

    public function questions(){
        return $this->hasMany('App\Question');
    }
}
