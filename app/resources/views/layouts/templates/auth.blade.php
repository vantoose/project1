@extends('layouts.app')

@section('template')
<div id="app">
	<x-layouts.navbar/>
	
	<main>
		@yield('content')
	</main>

	<x-layouts.footer/>
</div>
@endsection
