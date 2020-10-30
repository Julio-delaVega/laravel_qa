@if($answers_count > 0)
  <div class="row mt-4" v-cloak>
    <div class="col-md-12">
      <div class="card">
        <div class="card-body">
          <div class="card-title">
            <h2>{{ $answers_count }} {{ Str::plural('answer', $question->answers_count) }}</h2>
          </div><!-- card-title -->
          <hr>
          @include('layouts._messages')
          @foreach($answers as $answer)
            @include('answers._answer', [
              'answer' => $answer
            ])
          @endforeach
        </div><!-- card-body -->
      </div><!-- card -->
    </div><!-- col -->
  </div><!-- row -->
@endif