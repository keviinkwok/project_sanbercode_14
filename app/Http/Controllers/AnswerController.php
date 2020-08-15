<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Answer;
use App\Question;

class AnswerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'isi' => 'required'
        ]);

        $insert = Auth::user()->answers()->create(
            [
                'isi' => $request->isi,
                'question_id' => $request->id
            ]
        );
        return redirect()->action('QuestionController@show', ['question' => $request->id]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request , $id)
    {           
        $answer = Answer::find($id);
        $question = Question::find($request->id);
        return view('answer/edit-answer', compact('answer','question'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'isi' => 'required'
        ]);

        $insert = Auth::user()->answers()->where('id',$id)->update(
            [
                'isi' => $request->isi
            ]
        );
        return redirect()->action('QuestionController@show', ['question' => $request->id]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {
        Answer::destroy($id);
        return redirect()->action('QuestionController@show', ['question' => $request->id]);
    }

    public function correctAns(Request $request,$id)
    {
        //Update CORRECT ANSWER
        Auth::user()->questions()->where('id','=',$request->id)->update(
            [
                'correct_answer_id' => $id
            ]
        );


        //Menambahkan Reputasi
        $user = Auth::user()->where('id','=',$request->user_id)->first();
        $reputasi = $user->reputasi;
        if($reputasi == ''){
            $reputasi = 0;
        }
        $reputasi = $reputasi + 15;

        Auth::user()->where('id','=',$request->user_id)->update([
            'reputasi' => $reputasi
        ]);

        return redirect()->action('QuestionController@show', ['question' => $request->id]);
    }
}
