@extends('layouts.templates.default')

@section('content')
<div class="container">
    <div class="list-group mb-3">
        <a href="{{ route('homes.5bukv') }}" class="list-group-item list-group-item-action">{{ __('routes.web.homes.5bukv') }}</a>
        <a href="{{ route('homes.hash') }}" class="list-group-item list-group-item-action">{{ __('routes.web.homes.hash') }}</a>
        <a href="" class="list-group-item list-group-item-action disabled">{{ __('routes.web.homes.torrent') }}</a>
    </div>

    <div class="card">
        <div class="card-header">{{ __('routes.web.homes.posts.index') }}</div>
        <div class="list-group list-group-flush">
            @foreach ($posts as $post)
                @can('view', $post)
                    <a href="{{ route('homes.posts.show', $post) }}" class="list-group-item list-group-item-action" style="overflow-x: auto;">
                        <div>{{ $post->title }}</div>
                        <div class="small text-muted text-nowrap">
                            <span>{{ DateHelper::isoFormat($post->published_at) }}</span>
                            <span>&mdash;</span>
                            <span>{{ $post->user->name }}</span>
                        </div>
                    </a>
                @endcan
            @endforeach
            <a href="{{ route('homes.posts.index') }}" class="list-group-item list-group-item-action" style="overflow-x: auto;">...</a>
        </div>
    </div>



</div>
@endsection