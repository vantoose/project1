@extends('layouts.templates.default')

@section('content')
<div class="container">
    <div class="list-group mb-3">
        <a href="{{ route('5bukv') }}" class="list-group-item list-group-item-action">{{ __('routes.web.5bukv') }}</a>
    </div>

    @can('memos')
        <form method="POST" action="{{ route('memos.store') }}" class="mb-3">
            @csrf
            <div class="card mb-3">
                <div class="card-header">{{ __('routes.web.memos.index') }}</div>
                <div class="card-body p-0">
                    <div class="form-group mb-0">
                        <textarea class="form-control border-0" id="content" name="content" placeholder="{{ __('Content') }}" rows="3">{{ old('content') }}</textarea>
                    </div>
                </div>
            </div>
            <button type="submit" class="btn btn-primary">{{ __('routes.web.memos.store') }}</button>
        </form>
    @endcan

    <div class="card">
        <div class="card-header">{{ __('routes.web.public.posts.index') }}</div>
        <div class="list-group list-group-flush">
            @foreach ($posts as $post)
                @can('view', $post)
                    <a href="{{ route('public.posts.show', $post) }}" class="list-group-item list-group-item-action" style="overflow-x: auto;">
                        <div>{{ $post->title }}</div>
                        <div class="small text-muted text-nowrap">
                            <span>{{ DateHelper::isoFormat($post->published_at) }}</span>
                            <span>&mdash;</span>
                            <span>{{ $post->user->name }}</span>
                        </div>
                    </a>
                @endcan
            @endforeach
            <a href="{{ route('public.posts.index') }}" class="list-group-item list-group-item-action" style="overflow-x: auto;">...</a>
        </div>
    </div>



</div>
@endsection