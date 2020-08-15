<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', 'IndexController@index');
Route::resource('question','QuestionController');
Route::resource('answer','AnswerController');
Route::post('correctAnswer/{id}','AnswerController@correctAns');
Route::post('upVoteQue','VoteQueController@upVote');
Route::post('downVoteQue','VoteQueController@downVote');
Route::post('upVoteAns/{id}','VoteAnsController@upVote');
Route::post('downVoteAns/{id}','VoteAnsController@downVote');

Auth::routes();
Route::group(['prefix' => 'laravel-filemanager', 'middleware' => ['web', 'auth']], function () {
    \UniSharp\LaravelFilemanager\Lfm::routes();
});

