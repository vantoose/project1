@extends('layouts.app')

@section('template')
<div id="app">
	<x-layouts.navbar/>

	<main>
		<div class="container">
			@if(Breadcrumbs::exists(Route::currentRouteName()))
				{{ Breadcrumbs::render() }}
			@else
				@yield('breadcrumbs')
			@endif
		</div>
		
		<div class="container">
			<x-layouts.alerts/>
		</div>
		
		@yield('content')
	</main>

	<x-layouts.footer/>
</div>
@endsection
