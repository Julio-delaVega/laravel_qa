<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Answer;

class AcceptAnswerController extends Controller
{
  /**
   * Handle the incoming request.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return \Illuminate\Http\Response
   */
  public function __invoke(Answer $answer)
  {
    $this->authorize('acceptBest', $answer);
    $answer->question->acceptBestAnswer($answer);
    return response()->json([
      'message' => 'You have accepted this answer as best answer'
    ]);
  }
}
