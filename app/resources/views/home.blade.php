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
                    <a href="{{ route('posts.show', $post) }}" class="list-group-item list-group-item-action" style="overflow-x: auto;">
                        <div class="d-flex align-items-center">
                            <div class="mr-2">
                                <div>{{ $post->title }}</div>
                                <div class="small text-muted text-nowrap">
                                    @if ($post->is_published)
                                    <span>{{ DateHelper::isoFormat($post->published_at) }}</span>
                                    @else
                                    <span>{{ DateHelper::isoFormat($post->updated_at) }}</span>
                                    @endif
                                    <span>&mdash;</span>
                                    <span>{{ $post->user->name }}</span>
                                </div>
                            </div>

                            <div class="ml-auto">
                                <small>[{{ $post->id }}]</small>
                            </div>
                        </div>
                    </a>
                @endcan
            @endforeach
            <a href="{{ route('posts.published') }}" class="list-group-item list-group-item-action" style="overflow-x: auto;">...</a>
        </div>
    </div>



</div>
@endsection