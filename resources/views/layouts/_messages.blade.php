@if(session('success'))
  <div class="alert alert-success alert-dismissable fade show">
    <strong>Success!</strong> {{ session('success') }}
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
      <span aria-hidden="true">&times;</span>
    </button>
  </div><!-- alert -->
@endif