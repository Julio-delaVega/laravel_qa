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
            @include('answers._answer', [
              'answer' => $answer
            ])
            {{-- <hr> --}}
          @endforeach
        </div><!-- cart-body -->
      </div><!-- cart -->
    </div><!-- col -->
  </div><!-- row -->
@endif