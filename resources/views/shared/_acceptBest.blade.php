@can('acceptBest', $model)
<form id="accept-answer-{{ $model->id }}" method="POST" action="{{ route('answers.accept', $model->id) }}">
  @csrf
  <a title="Mark as best answer" class="{{ $model->status }} mt-2" 
    onclick="event.preventDefault(); document.getElementById('accept-answer-{{ $model->id }}').submit()"
  >
    <i class="fas fa-check fa-2x"></i>
  </a>
</form>
@else
  @if($model->is_best)
    <a title="Marked as best answer" class="{{ $model->status }} mt-2">
      <i class="fas fa-check fa-2x"></i>
    </a>
  @endif
@endcan