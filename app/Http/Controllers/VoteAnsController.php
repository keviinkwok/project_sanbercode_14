<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Answer;

class VoteAnsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function upVote(Request $request,$id)
    {
        $check = Answer::find($request->id)->voteAnswers()->where('user_id','=', Auth::id())->first();
        // dd($check);
        if($check == ''){
            Auth::user()->voteAnswers()->create(
                [
                    'answer_id' => $request->id,
                    'poin' => 1
                ]
            );
        }else{
            Auth::user()->voteAnswers()->where('answer_id','=',$request->id)->update(
                [
                    'poin' => 1
                ]
            );
        }

        $user = Auth::user()->where('id','=',$request->user_id)->first();
        $reputasi = $user->reputasi;
        if($reputasi == ''){
            $reputasi = 0;
        }
        $reputasi = $reputasi + 10;

        // dd($reputasi);
        Auth::user()->where('id','=',$request->user_id)->update([
            'reputasi' => $reputasi
        ]);

        return redirect()->action('QuestionController@show', ['question' => $id]);
    }

    public function downVote(Request $request,$id)
    {
        $check = Answer::find($request->id)->voteAnswers()->where('user_id','=', Auth::id())->first();
        // dd($check);
        if($check == ''){
            Auth::user()->voteAnswers()->create(
                [
                    'answer_id' => $request->id,
                    'poin' => -1
                ]
            );
        }else{
            Auth::user()->voteAnswers()->where('answer_id','=',$request->id)->update(
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
        return redirect()->action('QuestionController@show', ['question' => $id]);
    }
}
