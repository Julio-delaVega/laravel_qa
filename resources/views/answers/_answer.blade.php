<div class="media post">
  @include('shared._votes', [
    'model' => $answer
  ])
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