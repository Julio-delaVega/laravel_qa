<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
  use Notifiable;

  /**
   * The attributes that are mass assignable.
   *
   * @var array
   */
  protected $fillable = [
    'name', 'email', 'password',
  ];

  /**
   * The attributes that should be hidden for arrays.
   *
   * @var array
   */
  protected $hidden = [
    'password', 'remember_token',
  ];

  /**
   * The attributes that should be cast to native types.
   *
   * @var array
   */
  protected $casts = [
    'email_verified_at' => 'datetime',
  ];

  public function questions()
  {
    return $this->hasMany(Question::class);
  }

  public function answers()
  {
    return $this->hasMany(Answer::class);
  }

  public function favorites()
  {
    return $this->belongsToMany(Question::class, 'favorites')->withTimestamps();
  }
  
  public function voteQuestions()
  {
    return $this->morphedByMany(Question::class, 'votable');
  }

  public function voteAnswers()
  {
    return $this->morphedByMany(Answer::class, 'votable');
  }

  public function voteQuestion(Question $question, $vote)
  {
    $vote_questions = $this->voteQuestions();
    if($vote_questions->where('votable_id', $question->id)->exists())
    {
      $vote_questions->updateExistingPivot($question, ['vote' => $vote]);
    }
    else
    {
      $vote_questions->attach($question, ['vote' => $vote]);
    }
    $question->load('votes');
    $question->votes_count = (int) $question->votes()->sum('vote');
    $question->save();
  }

  public function voteAnswer(Answer $answer, $vote)
  {
    $vote_answers = $this->voteAnswers();
    if($vote_answers->where('votable_id', $answer->id)->exists())
    {
      $vote_answers->updateExistingPivot($answer, ['vote' => $vote]);
    }
    else
    {
      $vote_answers->attach($answer, ['vote' => $vote]);
    }
    $answer->load('votes');
    $answer->votes_count = (int) $answer->votes()->sum('vote');
    $answer->save();
  }

  public function getUrlAttribute()
  {
    // return route('users.show', $thisi->id);
    return "#";
  }

  public function getAvatarAttribute()
  {
    $email = $this->email;
    $size = 32;
    return "https://www.gravatar.com/avatar/" . md5( strtolower( trim( $email ) ) ) . "?s=" . $size;
    return 'https://www.gravatar.com/avatar/' . md5( strtolower( trim( $email ) ) ) . "&s=" . $size;
  }
}
