<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use \Auth;
use App\Answer;

class VoteAnswerController extends Controller
{
  public function __invoke(Answer $answer)
  {
    $vote = (int) request()->vote;
    $votes_count = Auth::user()->voteAnswer($answer, $vote);
    return response()->json([
      'message' => 'Thanks for your feedback',
      'votes_count' => $votes_count
    ]);
  }
}
