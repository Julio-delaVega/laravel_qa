@if($model instanceof App\Question)
  @php
    $name = 'question';
    $firstURISegment = 'questions';
  @endphp
@else
  @php
    $name = 'answer';
    $firstURISegment = 'answers';
  @endphp
@endif

@php
  $form_id = $name.'-'.$model->id;
  $form_action = "/$firstURISegment/$model->id/vote"
@endphp

<div class="d-flex flex-column vote-controls">
  <form id="up-vote-{{ $form_id }}" action="/{{ $form_action }}/vote" method="POST">
    @csrf
    <input type="hidden" name="vote" value="1">
    <a title="This {{ $name }} is useful" class="vote-up {{ Auth::guest() ? 'off' : '' }}"
      onclick="event.preventDefault(); document.getElementById('up-vote-{{ $form_id }}').submit()"
    >
      <i class="fas fa-caret-up fa-3x"></i>
    </a>
  </form>
  <span class="votes-count">
    {{ $model->votes_count }}
  </span>
  <form id="down-vote-{{ $form_id }}" action="/{{ $form_action }}/vote" method="POST">
    @csrf
    <input type="hidden" name="vote" value="-1">
    <a title="This {{ $name }} is not useful" class="vote-down {{ Auth::guest() ? 'off' : '' }}"
      onclick="event.preventDefault(); document.getElementById('down-vote-{{ $form_id }}').submit()"
    >
      <i class="fas fa-caret-down fa-3x"></i>
    </a>
  </form>

  @if($model instanceof App\Question)
    <favorite :question="{{ $model }}"></favorite>
  @elseif($model instanceof App\Answer)
    @include('shared._acceptBest', [
      'model' => $model
    ])
  @endif
</div>