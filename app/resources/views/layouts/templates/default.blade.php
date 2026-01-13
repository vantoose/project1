@extends('layouts.app')

@section('template')
<div id="app">
	<x-layouts.navbar/>

	<main>
		<div class="container">
			<x-layouts.alerts/>
		</div>
		
		@yield('content')
	</main>

	<x-layouts.footer/>
</div>
@endsection
