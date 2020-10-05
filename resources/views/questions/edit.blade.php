@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                  <div class="d-flex align-items-center">
                    <h2>Edit Question</h2>
                    <div class="ml-auto">
                      <a href="{{ route('questions.index') }}" class="btn btn-outline-secondary">Go Back</a>
                    </div>
                  </div>
                </div><!-- card-header -->
                <div class="card-body">
                  <form action="{{ route('questions.update', $question->id) }}" method="POST">
                    {{ method_field('PATCH') }}
                    @include('questions._form', ['button_text' => 'Update Question'])
                  </form>
                </div><!-- card-body -->
            </div><!-- card -->
        </div><!-- col -->
    </div><!-- row -->
</div><!-- container -->
@endsection