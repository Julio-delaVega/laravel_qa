<div class="row mt-4">
  <div class="col-md-12">
    <div class="card">
      <div class="card-body">
        <div class="card-title">
          <h2>{{ $answers_count }} {{ Str::plural('answer', $question->answers_count) }}</h2>
        </div><!-- cart-title -->
        <hr>
        @include('layouts._messages')
        @foreach($answers as $answer)
          <div class="media">
            <div class="d-flex flex-column vote-controls">
              <form id="up-vote-answer-{{ $answer->id }}" action="/answers/{{ $answer->id }}/vote" method="POST">
                @csrf
                <input type="hidden" name="vote" value="1">
                <a title="This answer is useful" class="vote-up {{ Auth::guest() ? 'off' : '' }}"
                  onclick="event.preventDefault(); document.getElementById('up-vote-answer-{{ $answer->id }}').submit()"
                >
                  <i class="fas fa-caret-up fa-3x"></i>
                </a>
              </form>
              <span class="votes-count">
                {{ $answer->votes_count }}
              </span>
              <form id="down-vote-answer-{{ $answer->id }}" action="/answers/{{ $answer->id }}/vote" method="POST">
                @csrf
                <input type="hidden" name="vote" value="-1">
                <a title="This answer is not useful" class="vote-down {{ Auth::guest() ? 'off' : '' }}"
                  onclick="event.preventDefault(); document.getElementById('down-vote-answer-{{ $answer->id }}').submit()"
                >
                  <i class="fas fa-caret-down fa-3x"></i>
                </a>
              </form>
              @can('acceptBest', $answer)
                <form id="accept-answer-{{ $answer->id }}" method="POST" action="{{ route('answers.accept', $answer->id) }}">
                  @csrf
                  <a title="Mark as best answer" class="{{ $answer->status }} mt-2" 
                    onclick="event.preventDefault(); document.getElementById('accept-answer-{{ $answer->id }}').submit()"
                  >
                    <i class="fas fa-check fa-2x"></i>
                  </a>
                </form>
              @else
                @if($answer->is_best)
                  <a title="Marked as best answer" class="{{ $answer->status }} mt-2">
                    <i class="fas fa-check fa-2x"></i>
                  </a>
                @endif
              @endcan
            </div><!-- d-flex -->
            <div class="media-body">
              {!! $answer->body_html !!}
              <div class="row">
                <div class="col-4">
                  <div class="ml-auto">
                    @can('update', $answer)
                      <a href="{{ route('questions.answers.edit', [$question->id, $answer->id]) }}" class="btn btn-outline-info btn-sm">Edit</a>
                    @endcan
                    @can('delete', $answer)
                      <form action="{{ route('questions.answers.destroy', [$question->id, $answer->id]) }}" method="POST" class="d-inline">
                        @csrf
                        @method('DELETE')
                        <button class="btn btn-outline-danger btn-sm" onclick="return confirm('Are you sure?')">Delete</button>
                      </form>
                    @endcan
                  </div><!-- ml-auto -->
                </div><!-- col-4 -->
                <div class="col-4"></div><!-- col-4 -->
                <div class="col-4">
                  <span class="text-muted">Answered {{ $answer->created_date }}</span>
                  <div class="media mt-2">
                    <a href="{{ $answer->user->url }}" class="pr-2">
                      <img src="{{ $answer->user->avatar }}">
                    </a>
                    <div class="media-body mt-1">
                      <a href="{{ $answer->user->url }}">{{ $answer->user->name }}</a>
                    </div><!-- media-body -->
                  </div><!-- media -->
                </div><!-- col-4 -->
              </div>
            </div><!-- media-body -->
          </div><!-- media -->
          <hr>
        @endforeach
      </div><!-- cart-body -->
    </div><!-- cart -->
  </div><!-- col -->
</div><!-- row -->