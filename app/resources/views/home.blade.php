@extends('layouts.templates.default')

@section('content')
<div class="container">
    <div class="list-group mb-3">
        <a href="{{ route('5bukv') }}" class="list-group-item list-group-item-action">{{ __('routes.web.5bukv') }}</a>
        <a href="{{ route('hash') }}" class="list-group-item list-group-item-action">{{ __('routes.web.hash') }}</a>
    </div>

    <div class="card">
        <div class="card-header">{{ __('routes.web.posts.index') }}</div>
        <div class="list-group list-group-flush">
            @foreach ($posts as $post)
                @can('view', $post)
                    <a href="{{ route('posts.show', $post) }}" class="list-group-item list-group-item-action d-flex" style="overflow-x: auto;">
                    <div class="mr-2">
                        <span>{{ $post->title }}</span>
                        <small class="text-muted text-nowrap">&mdash; {{ $post->user->name }}</small>
                    </div>
                    <div class="d-flex flex-column flex-md-row ml-auto">
                        <div class="align-self-md-center small text-nowrap">[{{ $post->id }}]</div>
                    </div>
                    </a>
                @endcan
            @endforeach
        </div>
    </div>



</div>
@endsection