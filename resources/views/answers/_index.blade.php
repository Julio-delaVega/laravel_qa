@if($answers_count > 0)
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
                    @include('shared._author', [
                      'model' => $answer,
                      'label' => 'Answered'
                    ])
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
@endif