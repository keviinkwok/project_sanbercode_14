<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Question;

class IndexController extends Controller
{
    public function index()
    {   
        $question = Question::all();
        return view('index',compact('question'));
    }
}
