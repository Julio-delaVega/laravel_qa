<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use \Auth;
use App\Question;

class VoteQuestionController extends Controller
{
  public function __invoke(Question $question)
  {
    $vote = (int) request()->vote;
    $votes_count = Auth::user()->voteQuestion($question, $vote);
    return response()->json([
      'message' => 'Thanks for your feedback',
      'votes_count' => $votes_count
    ]);
  }
}
