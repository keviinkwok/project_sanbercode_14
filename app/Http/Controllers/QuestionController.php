<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Question;
use App\Tag;
use App\Answer;

class QuestionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function __construct()
    {
        $this->middleware('auth');
    }
    
    public function index()
    {
        $questions = Auth::user()->questions;
        return view('question/question',compact('questions'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('question/create-question');
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
            'judul' => 'required',
            'isi' => 'required'
            
        ]);
        
        $tags_arr = explode(',',$request->tags);
        $tag_id = [];
        foreach($tags_arr as $tag_name){
            $tag = Tag::firstOrCreate(['tag' => $tag_name]);
            $tag_id[] = $tag->id;
        }
        
        $insert = Auth::user()->questions()->create(
                    [
                        'judul' => $request->judul,
                        'isi' => $request->isi
                    ]
                );
        $insert->tags()->sync($tag_id);
        return redirect('question')->with('status', 'Question added successfully!');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $question = Question::find($id);
        $answer = Answer::where("question_id",$id)->get();
        return view('question/detail-question', compact('question','answer'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $question = Question::find($id);
        $tagname = [];
        foreach ($question->tags as $tag) {
            $tagname[] = $tag->tag;
        }
        $stringTag = implode(",",$tagname);
        return view('question/update-question', compact('question','stringTag'));
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
            'judul' => 'required',
            'isi' => 'required'
        ]);

        Question::find($id)->tags()->detach();
        
        $tags_arr = explode(',',$request->tags);
        $tag_id = [];
        foreach($tags_arr as $tag_name){
            $tag = Tag::firstOrCreate(['tag' => $tag_name]);
            $tag_id[] = $tag->id;
        }

        $user = Auth::user();
        $edit = $user->questions()->where('id',$id)->update(
                    [
                        'judul' => $request->judul,
                        'isi' => $request->isi
                    ]
                );
                
        Question::find($id)->tags()->attach($tag_id);

        return redirect('question')->with('status', 'Question updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Question::destroy($id);
        return redirect('question')->with('status', 'Question deleted successfully!');
    }
}
