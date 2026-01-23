@extends('layouts.templates.default')

@section('content')
  <div class="container">

    <nav class="nav mb-3">
      @can('create', \App\Models\Post::class)
        <a class="nav-link" href="{{ route('posts.create') }}">{{ __('Create') }}</a>
      @endcan
    </nav>

    {{ $posts->links() }}

    <div class="list-group mb-3">
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

    {{ $posts->links() }}
    
  </div>
@endsection