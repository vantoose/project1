@extends('layouts.templates.blank')

@section('content')
  <div class="centered">
    <div class="text-center">
      <a class="btn btn-link btn-lg text-decoration-none" href="{{ route('home') }}" role="button">{{ __('routes.web.home') }}</a>
    </div>
    @if (! empty($location))
      <div class="text-center mt-2">
        <div>{{ $location->ip }}</div>
        <div class="small text-muted">
          <div>
            <span class="mr-1">{{ $location->latitude }}</span>
            <span>{{ $location->longitude }}</span>
          </div>
          <div>{{ $location->cityName }}, {{ $location->countryName }}</div>
          <div>{{ $location->timezone }}</div>
        </div>
      </div>
    @endif
  </div>
@endsection

@push('head')
<style>
  .centered {
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
  }
</style>
@endpush