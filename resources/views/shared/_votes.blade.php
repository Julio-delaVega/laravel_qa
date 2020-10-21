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
<div class="d-flex flex-column vote-controls">
  <form id="up-vote-{{ $name }}-{{ $model->id }}" action="/{{ $firstURISegment }}/{{ $model->id }}/vote" method="POST">
    @csrf
    <input type="hidden" name="vote" value="1">
    <a title="This {{ $name }} is useful" class="vote-up {{ Auth::guest() ? 'off' : '' }}"
      onclick="event.preventDefault(); document.getElementById('up-vote-{{ $name }}-{{ $model->id }}').submit()"
    >
      <i class="fas fa-caret-up fa-3x"></i>
    </a>
  </form>
  <span class="votes-count">
    {{ $model->votes_count }}
  </span>
  <form id="down-vote-{{ $name }}-{{ $model->id }}" action="/{{ $firstURISegment }}/{{ $model->id }}/vote" method="POST">
    @csrf
    <input type="hidden" name="vote" value="-1">
    <a title="This {{ $name }} is not useful" class="vote-down {{ Auth::guest() ? 'off' : '' }}"
      onclick="event.preventDefault(); document.getElementById('down-vote-{{ $name }}-{{ $model->id }}').submit()"
    >
      <i class="fas fa-caret-down fa-3x"></i>
    </a>
  </form>

  @if($model instanceof App\Question)
    @include('shared._favorite', [
      'model' => $model
    ])
  @elseif($model instanceof App\Answer)
    @include('shared._acceptBest', [
      'model' => $model
    ])
  @endif
</div>