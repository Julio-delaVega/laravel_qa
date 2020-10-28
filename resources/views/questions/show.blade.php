@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
      <div class="col-md-12">
        <div class="card">
          <div class="card-body">
            <div class="card-title">
              <div class="d-flex align-items-center">
                <h1>{{ $question->title }}</h1>
                <div class="ml-auto">
                  <a href="{{ route('questions.index') }}" class="btn btn-outline-secondary">Go Back</a>
                </div>
              </div>
            </div><!-- card-title -->
            <hr>
            <div class="media">
              @include('shared._votes', [
                'model' => $question
              ])
              <div class="media-body">
                {!! $question->excerpt !!}
                <div class="row">
                  <div class="col-4"></div>
                  <div class="col-4"></div>
                  <div class="col-4">
                    @include('shared._author', [
                      'model' => $question,
                      'label' => 'Asked'
                    ])
                  </div>
                </div>
              </div><!-- media body -->
            </div><!-- media -->
          </div><!-- card-body -->
        </div><!-- card -->
      </div><!-- col -->
    </div><!-- row -->
    @include('answers._index', [
      'answers' => $question->answers,
      'answers_count' => $question->answers_count
    ])
    @include('answers._create')
</div><!-- container -->
@endsection