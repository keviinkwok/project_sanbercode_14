<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Question;

class VoteQueController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function upVote(Request $request)
    {

        $check = Question::find($request->id)->voteQuestions()->where('user_id','=', Auth::id())->first();
        // dd($check);
        if($check == ''){
            Auth::user()->voteQuestions()->create(
                [
                    'question_id' => $request->id,
                    'poin' => 1
                ]
            );
        }else{
            Auth::user()->voteQuestions()->where('question_id','=',$request->id)->update(
                [
                    'question_id' => $request->id,
                    'poin' => 1
                ]
            );
        }
        
        
        // Menambahkan Reputasi ke User
        $user = Auth::user()->where('id','=',$request->user_id)->first();
        $reputasi = $user->reputasi;
        if($reputasi == ''){
            $reputasi = 0;
        }
        $reputasi = $reputasi + 10;

        Auth::user()->where('id','=',$request->user_id)->update([
            'reputasi' => $reputasi
        ]);
        return redirect()->action('QuestionController@show', ['question' => $request->id]);
    }

    public function downVote(Request $request)
    {

        $check = Question::find($request->id)->voteQuestions()->where('user_id','=', Auth::id())->first();
        // dd($check);
        if($check == ''){
            Auth::user()->voteQuestions()->create(
                [
                    'question_id' => $request->id,
                    'poin' => -1
                ]
            );
        }else{
            Auth::user()->voteQuestions()->where('question_id','=',$request->id)->update(
                [
                    'poin' => -1
                ]
            );
        }

        $user = Auth::user()->where('id','=',$request->user_id)->first();
        $reputasi = $user->reputasi;
        if($reputasi == ''){
            $reputasi = 0;
        }
        $reputasi = $reputasi - 1;

        // dd($reputasi);
        Auth::user()->where('id','=',$request->user_id)->update([
            'reputasi' => $reputasi
        ]);

        return redirect()->action('QuestionController@show', ['question' => $request->id]);
    }
}
