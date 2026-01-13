@foreach ($alerts as $alert)
  <div class="alert alert-{{ $alert['type'] }} alert-dismissible fade show" role="alert">
  	@if ($alert['type'] == 'danger')
      <strong>{{ __('Error!') }}</strong>
    @endif
  	@if ($alert['type'] == 'warning')
    	<strong>{{ __('Warning!') }}</strong>
    @endif
    {{ $alert['message'] }}

    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
      <span aria-hidden="true">&times;</span>
    </button>

  </div>
@endforeach
