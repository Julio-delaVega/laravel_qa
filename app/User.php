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

  protected $appends = ['url', 'avatar'];

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
    return $this->_vote($vote_questions, $question, $vote);
  }

  public function voteAnswer(Answer $answer, $vote)
  {
    $vote_answers = $this->voteAnswers();
    return $this->_vote($vote_answers, $answer, $vote);
  }

  private function _vote($relationship, $model, $vote)
  {
    if($relationship->where('votable_id', $model->id)->exists())
    {
      $relationship->updateExistingPivot($model, ['vote' => $vote]);
    }
    else
    {
      $relationship->attach($model, ['vote' => $vote]);
    }
    $model->load('votes');
    $model->votes_count = (int) $model->votes()->sum('vote');
    $model->save();
    return $model->votes_count;
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
