@csrf
<div class="form-group">
  <label for="question-title">Question Title</label>
  <input id="question-title" type="text" class="form-control {{ $errors->has('title') ? 'is-invalid' : '' }}" value="{{ old('title', $question->title) }}" name="title">

  @if($errors->has('title'))
    <div class="invalid-feedback">
      <strong>{{ $errors->first('title') }}</strong>
    </div><!-- invalid-feedback -->
  @endif
</div><!-- form-group -->
<div class="form-group">
  <label for="question-body">Explain your question</label>
  <textarea id="question-body" class="form-control {{ $errors->has('body') ? 'is-invalid' : '' }}" rows="10" name="body">{{ old('body', $question->body) }}</textarea>

  @if($errors->has('body'))
    <div class="invalid-feedback">
      <strong>{{ $errors->first('body') }}</strong>
    </div><!-- invalid-feedback -->
  @endif
</div><!-- form-group -->
<div class="form-group">
  <button type="submit" class="btn btn-outline-primary btn-lg">{{ $button_text }}</button>
</div><!-- form-group -->