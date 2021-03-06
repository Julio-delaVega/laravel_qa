<?php

namespace App\Http\Controllers\Api;

use App\Answer;
use App\Http\Resources\AnswerResource;
use App\Question;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use \Auth;

class AnswersController extends Controller
{
  public function index(Question $question)
  {
    $answers = $question->answers()
    ->where(function ($q) {
      if(request()->has('excludes'))
      {
        $q->whereNotIn('id', request()->query('excludes'));
      }
    })
    ->with('user')
    ->simplePaginate(3);
    return AnswerResource::collection($answers);
  }

  /**
   * Store a newly created resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return \Illuminate\Http\Response
   */
  public function store(Question $question, Request $request)
  {
    $request->validate([
      'body' => 'required'
    ]);

    $answer = $question->answers()->create([
      'body' => $request->body,
      'user_id' => Auth::id()
    ]);

    return response()->json([
      'message' => 'Your answer has been submitted succesfully',
      'answer' => new AnswerResource($answer->load('user'))
    ]);
  }

  /**
   * Update the specified resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @param  \App\Answer  $answer
   * @return \Illuminate\Http\Response
   */
  public function update(Request $request, Question $question, Answer $answer)
  {
    $this->authorize('update', $answer);

    $answer->update($request->validate([
      'body' => 'required'
    ]));

    return response()->json([
      'message' => 'Your answer has been updated',
      'body_html' => $answer->body_html
    ]);
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param  \App\Answer  $answer
   * @return \Illuminate\Http\Response
   */
  public function destroy(Question $question, Answer $answer)
  {
    $this->authorize('delete', $answer);

    $answer->delete();

    return response()->json([
      'message' => 'Your answer has been removed.'
    ]);
  }
}
