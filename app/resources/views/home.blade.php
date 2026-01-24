@extends('layouts.templates.default')

@section('content')
<div class="container">
    <div class="list-group">
        <a href="{{ route('5bukv') }}" class="list-group-item list-group-item-action">{{ __('routes.web.5bukv') }}</a>
        <a href="{{ route('hash') }}" class="list-group-item list-group-item-action">{{ __('routes.web.hash') }}</a>
    </div>
</div>
@endsection