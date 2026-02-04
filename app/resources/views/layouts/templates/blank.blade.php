@extends('layouts.app')

@section('template')
<div id="app">
	<main>
		<div class="container">
			<x-layouts.alerts/>
		</div>
		
		@yield('content')
	</main>
</div>
@endsection
