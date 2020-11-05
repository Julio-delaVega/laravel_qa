<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;

class User extends Authenticatable
{
  use Notifiable, HasApiTokens;

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

  public function posts()
  {
    $type = request()->get('type');

    if($type === 'questions')
    {
      $posts = $this->questions()->get();
    }
    else 
    {
      $posts = $this->answers()->with('question')->get();
      if($type !== 'answers')
      {
        $questions = $this->questions()->get();
        $posts = $posts->merge($questions);
      }
    }

    $data = collect();

    foreach($posts as $post)
    {
      $item = [
        'votes_count' => $post->votes_count,
        'created_at' => $post->created_at->format('d M Y')
      ];

      if($post instanceof Answer)
      {
        $item['type'] = 'answer';
        $item['title'] = $post->question->title;
        $item['accepted'] = $post->question->best_answer_id === $post->id;
      }
      else
      {
        $item['type'] = 'question';
        $item['title'] = $post->title;
        $item['accepted'] = (bool) $post->best_answer_id;
      }

      $data->push($item);
    }
    return $data->sortByDesc('votes_count')->values()->all();
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
