@extends('layouts.app')

@section('content')
<div class="container">
  <div class="row justify-content-center">
    <div class="col-md-12">
      <div class="card">
        <div class="card-header">
          <div class="d-flex align-items-center">
            <h2>All Questions</h2>
            <div class="ml-auto">
              <a href="{{ route('questions.create') }}" class="btn btn-outline-secondary">Ask Question</a>
            </div><!-- ml-auto -->
          </div><!-- d-flex -->
        </div><!-- card-header -->
        <div class="card-body">
          @include('layouts._messages')
          @forelse($questions as $question)
            <div class="media">
              <div class="counters d-flex flex-column">
                <div class="vote">
                  <strong>{{ $question->votes_count }}</strong> {{ Str::plural('vote', $question->votes_count) }}
                </div><!-- vote -->
                <div class="status {{ $question->status }}">
                  <strong>{{ $question->answers_count }}</strong> {{ Str::plural('answer', $question->answers_count) }}
                </div><!-- status -->
                <div class="view">
                  {{ $question->views }} {{ Str::plural('view', $question->views) }}
                </div><!-- view -->
              </div><!-- counters -->
              <div class="media-body">
                <div class="d-flex align-items-center">
                  <h3 class="mt-0"><a href="{{ $question->url }}" >{{ $question->title }}</a></h3>
                  <div class="ml-auto">
                    @can('update', $question)
                      <a href="{{ route('questions.edit', $question->id) }}" class="btn btn-outline-info btn-sm">Edit</a>
                    @endcan
                    @can('delete', $question)
                      <form action="{{ route('questions.destroy', $question->id) }}" method="POST" class="d-inline">
                        @csrf
                        @method('DELETE')
                        <button class="btn btn-outline-danger btn-sm" onclick="return confirm('Are you sure?')">Delete</button>
                      </form>
                    @endcan
                  </div><!-- ml-auto -->
                </div><!-- d-flex -->
                <p class="lead">
                  Asked by <a href="{{ $question->user->url }}">{{ $question->user->name }}</a>
                  <small class="text-muted">{{ $question->created_date }}</small>
                </p>
                <div class="excerpt">
                  {{ $question->excerpt }}
                </div><!-- excerpt -->
              </div><!-- media-body -->
            </div><!-- media -->
            <hr>
          @empty
            <div class="alert alert-warning">
              <strong>Sorry!</strong> There are no questions available.
            </div>
          @endforelse
          <div class="mx-auto">
            {{ $questions->links() }}
          </div><!-- mx-auto -->
        </div><!-- card-body -->
      </div><!-- card -->
    </div><!-- col -->
  </div><!-- row -->
</div><!-- container -->
@endsection