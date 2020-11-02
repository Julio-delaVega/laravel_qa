<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use \Auth;
use App\Answer;

class VoteAnswerController extends Controller
{
  public function __construct()
  {
    $this->middleware('auth');
  }

  public function __invoke(Answer $answer)
  {
    $vote = (int) request()->vote;
    $votes_count = Auth::user()->voteAnswer($answer, $vote);
    if(request()->expectsJson())
    {
      return response()->json([
        'message' => 'Thanks for your feedback',
        'votes_count' => $votes_count
      ]);
    }
    return back();
  }
}
