<div class="py-3 bg-white mt-4">
  <div class="container d-flex justify-content-between">
    <div>
			@if (env('APP_YEAR'))
				<span>{{ env('APP_YEAR') }}</span>
			@else
				<span>{{ \Carbon\Carbon::now()->year }}</span>
			@endif
			@if (env('APP_YEAR') && \Carbon\Carbon::now()->year > env('APP_YEAR'))
				<span>&dash; {{ \Carbon\Carbon::now()->year }}</span>
			@endif
      <span>{{ env('APP_NAME') }}</span>
    </div>
    <div>
      <span class="text-muted">developed by</span>
      <a href="http://ishipilov.ru" target="_blank">iShipilov</a>
    </div>
  </div>
</div>

@push('head')
<style>
	main {
		min-height: calc(100vh - (.5rem + 39.0333px + .5rem + 1.5rem) - (1rem + 23.5333px + 1rem + 1.5rem));
	}
</style>
@endpush
