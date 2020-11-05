<?php

namespace App\Http\Controllers\Api;

use App\Question;
use App\Http\Resources\QuestionDetailsResource;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class QuestionDetailsController extends Controller
{
  /**
   * Handle the incoming request.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return \Illuminate\Http\Response
   */
  public function __invoke(Question $question)
  {
    $question->increment('views');
    return new QuestionDetailsResource($question);
  }
}
