@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                  <div class="d-flex align-items-center">
                    <h2>Ask Question</h2>
                    <div class="ml-auto">
                      <a href="{{ route('questions.index') }}" class="btn btn-outline-secondary">Go Back</a>
                    </div>
                  </div>
                </div><!-- card-header -->
                <div class="card-body">
                  <form action="{{ route('questions.store') }}" method="POST">
                    @csrf
                    <div class="form-group">
                      <label for="question-title">Question Title</label>
                      <input id="question-title" type="text" class="form-control {{ $errors->has('title') ? 'is-invalid' : '' }}" value="{{ old('title') }}" name="title">

                      @if($errors->has('title'))
                        <div class="invalid-feedback">
                          <strong>{{ $errors->first('title') }}</strong>
                        </div><!-- invalid-feedback -->
                      @endif
                    </div><!-- form-group -->
                    <div class="form-group">
                      <label for="question-body">Explain your question</label>
                      <textarea id="question-body" class="form-control {{ $errors->has('body') ? 'is-invalid' : '' }}" rows="10" name="body">{{ old('body') }}</textarea>

                      @if($errors->has('body'))
                        <div class="invalid-feedback">
                          <strong>{{ $errors->first('body') }}</strong>
                        </div><!-- invalid-feedback -->
                      @endif
                    </div><!-- form-group -->
                    <div class="form-group">
                      <button type="submit" class="btn btn-outline-primary btn-lg">Ask Question</button>
                    </div><!-- form-group -->
                  </form>
                </div><!-- card-body -->
            </div><!-- card -->
        </div><!-- col -->
    </div><!-- row -->
</div><!-- container -->
@endsection