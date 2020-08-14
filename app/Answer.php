<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Answer extends Model
{
    protected $table = 'answers';
    protected $guarded = [];

    public function author(){
        return $this->belongsTo('App\User','user_id');
    }
}
