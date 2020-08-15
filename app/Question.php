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

    public function answer(){
        return $this->hasMany('App\Answer');
    }

    public function tags(){
        return $this->belongstoMany('App\Tag','question_tags','question_id','tag_id');
    }

    public function voteQuestions(){
        return $this->hasMany('App\VoteQuestions');
    }

    public function voteAnswers(){
        return $this->hasMany('App\VoteAnswers');
    }

    public function correctAnswer(){
        return $this->belongsTo('App\Answer');
    }
}
