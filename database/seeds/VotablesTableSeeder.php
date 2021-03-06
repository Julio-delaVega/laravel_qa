<?php

use Illuminate\Database\Seeder;
use App\User;
use App\Question;
use App\Answer;

class VotablesTableSeeder extends Seeder
{
  /**
   * Run the database seeds.
   *
   * @return void
   */
  public function run()
  {
    \DB::table('votables')->truncate();

    $users = User::all();
    $users_count = $users->count();
    $votes = [-1, 1];

    foreach(Question::all() as $question)
    {
      for($i = 0; $i < rand(0, $users_count); $i++)
      {
        $user = $users[$i];
        $user->voteQuestion($question, $votes[rand(0, 1)]);
      }
    }

    foreach(Answer::all() as $answer)
    {
      for($i = 0; $i < rand(0, $users_count); $i++)
      {
        $user = $users[$i];
        $user->voteAnswer($answer, $votes[rand(0, 1)]);
      }
    }
  }
}
