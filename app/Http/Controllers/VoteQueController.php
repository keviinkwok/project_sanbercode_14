<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Question;

class VoteQueController extends Controller
{   
    //Mengamankan Route
    public function __construct()
    {
        $this->middleware('auth');
    }

    //Fungsi Melakukan UP VOTE
    public function upVote(Request $request)
    {

        //Mengecek data vote apakah sudah ada di DB atau belum
        $check = Question::find($request->id)->voteQuestions()->where('user_id','=', Auth::id())->first();
        // Jika belum ada INSERT
        if($check == ''){
            Auth::user()->voteQuestions()->create(
                [
                    'question_id' => $request->id,
                    'poin' => 1
                ]
            );
        //Jika sudah ada UPDATE
        }else{
            Auth::user()->voteQuestions()->where('question_id','=',$request->id)->update(
                [
                    'question_id' => $request->id,
                    'poin' => 1
                ]
            );
        }
        
        
        //Mengecek data reputasi
        $user = Auth::user()->where('id','=',$request->user_id)->first();
        $reputasi = $user->reputasi;
        if($reputasi == ''){
            $reputasi = 0;
        }
        $reputasi = $reputasi + 10;

        // Menambahkan Reputasi ke User
        Auth::user()->where('id','=',$request->user_id)->update([
            'reputasi' => $reputasi
        ]);
        return redirect()->action('QuestionController@show', ['question' => $request->id]);
    }

    //Fungsi Melakukan DOWN VOTE
    public function downVote(Request $request)
    {
        //Mengecek data vote apakah sudah ada di DB atau belum
        $check = Question::find($request->id)->voteQuestions()->where('user_id','=', Auth::id())->first();
        // Jika belum ada INSERT
        if($check == ''){
            Auth::user()->voteQuestions()->create(
                [
                    'question_id' => $request->id,
                    'poin' => -1
                ]
            );
        //Jika sudah ada UPDATE
        }else{
            Auth::user()->voteQuestions()->where('question_id','=',$request->id)->update(
                [
                    'poin' => -1
                ]
            );
        }

        //Mengecek data reputasi
        $user = Auth::user()->where('id','=',$request->user_id)->first();
        $reputasi = $user->reputasi;
        if($reputasi == ''){
            $reputasi = 0;
        }
        $reputasi = $reputasi - 1;

        // Menambahkan Reputasi ke User
        Auth::user()->where('id','=',$request->user_id)->update([
            'reputasi' => $reputasi
        ]);

        return redirect()->action('QuestionController@show', ['question' => $request->id]);
    }
}
