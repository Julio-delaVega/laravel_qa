@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
      <div class="col-md-12">
        <div class="card">
          <div class="card-body">
            <div class="card-title">
              <div class="d-flex align-items-center">
                <h1>{{ $question->title }}</h1>
                <div class="ml-auto">
                  <a href="{{ route('questions.index') }}" class="btn btn-outline-secondary">Go Back</a>
                </div>
              </div>
            </div><!-- card-title -->
            <hr>
            <div class="media">
              <div class="d-flex flex-column vote-controls">
                <form id="up-vote-question-{{ $question->id }}" action="/questions/{{ $question->id }}/vote" method="POST">
                  @csrf
                  <input type="hidden" name="vote" value="1">
                  <a title="This question is useful" class="vote-up {{ Auth::guest() ? 'off' : '' }}"
                    onclick="event.preventDefault(); document.getElementById('up-vote-question-{{ $question->id }}').submit()"
                  >
                    <i class="fas fa-caret-up fa-3x"></i>
                  </a>
                </form>
                <span class="votes-count">
                  {{ $question->votes_count }}
                </span>
                <form id="down-vote-question-{{ $question->id }}" action="/questions/{{ $question->id }}/vote" method="POST">
                  @csrf
                  <input type="hidden" name="vote" value="-1">
                  <a title="This question is not useful" class="vote-down {{ Auth::guest() ? 'off' : '' }}"
                    onclick="event.preventDefault(); document.getElementById('down-vote-question-{{ $question->id }}').submit()"
                  >
                    <i class="fas fa-caret-down fa-3x"></i>
                  </a>
                </form>
                <form id="favorite-question-{{ $question->id }}" action="/questions/{{ $question->id }}/favorites" method="POST">
                  @csrf
                  @if($question->is_favorited)
                    @method('DELETE')
                  @endif
                  <a title="Click to mark as favorite question (Click again to undo)"
                    class="favorite mt-2 {{ Auth::guest() ? 'off' : ($question->is_favorited ? 'favorited' : '')}}"
                    onclick="event.preventDefault(); document.getElementById('favorite-question-{{ $question->id }}').submit()"
                  >
                    <i class="fas fa-star fa-2x"></i>
                    <span class="favorites-count">
                      {{ $question->favorites_count }}
                    </span>
                  </a>
                </form>
              </div>
              <div class="media-body">
                {!! $question->body_html !!}
                <div class="float-right">
                  <span class="text-muted">Answered {{ $question->created_date }}</span>
                  <div class="media mt-2">
                    <a href="{{ $question->user->url }}" class="pr-2">
                      <img src="{{ $question->user->avatar }}">
                    </a>
                    <div class="media-body mt-1">
                      <a href="{{ $question->user->url }}">{{ $question->user->name }}</a>
                    </div><!-- media-body -->
                  </div><!-- media -->
                </div><!-- float-right -->
              </div><!-- media body -->
            </div><!-- media -->
          </div><!-- card-body -->
        </div><!-- card -->
      </div><!-- col -->
    </div><!-- row -->
    @include('answers._index', [
      'answers' => $question->answers,
      'answers_count' => $question->answers_count
    ])
    @include('answers._create')
</div><!-- container -->
@endsection