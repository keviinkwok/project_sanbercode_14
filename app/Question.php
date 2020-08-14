<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    protected $table = 'questions';
    protected $guarded = [];

    public function author(){
        return $this->belongsTo('App\User','user_id');
    }

    public function tags(){
        return $this->belongstoMany('App\Tag','question_tags','question_id','tag_id');
    }
}
