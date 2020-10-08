<div class="row mt-4">
  <div class="col-md-12">
    <div class="card">
      <div class="card-body">
        <div class="card-title">
          <h3>Your Answer</h3>
        </div><!-- cart-title -->
        <hr>
        <form action="{{ route('questions.answers.store', $question->id) }}" method="POST">
          @csrf
          <div class="form-group">
            <textarea name="body" rows="7" class="form-control {{ $errors->has('body') ? 'is-invalid' : '' }}"></textarea>
            @if($errors->has('body'))
              <div class="invalid-feedback">
                <strong>{{ $errors->first('body') }}</strong>
              </div>
            @endif
          </div><!-- form-group -->
          <div class="form-group">
            <button type="submit" class="btn btn-lg btn-outline-primary">Submit</button>
          </div><!-- form-group -->
        </form>
      </div><!-- cart-body -->
    </div><!-- cart -->
  </div><!-- col -->
</div><!-- row -->