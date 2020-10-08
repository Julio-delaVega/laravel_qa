<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use League\CommonMark\CommonMarkConverter;

class Answer extends Model
{
  protected $fillable = ['body', 'user_id'];

  public function question()
  {
    return $this->belongsTo(Question::class);
  }

  public function user()
  {
    return $this->belongsTo(User::class);
  }

  public function getBodyHtmlAttribute()
  {
    $markdown = new CommonMarkConverter(['allow_unsafe_links' => false]);
    return $markdown->convertToHtml($this->body);
  }

  public function getCreatedDateAttribute()
  {
    return $this->created_at->diffForHumans();
  }

  public static function boot()
  {
    parent::boot();

    static::created(function($answer) {
      $answer->question->increment('answers_count');
      $answer->question->save();
    });
  }
}
