@extends('layouts.templates.default')

@section('page-title', $post->title)

@section('content')
  <div class="container">

    <nav class="nav mb-3">
      @can('update', $post)
        <a class="nav-link" href="{{ route('posts.edit', $post) }}">{{ __('routes.web.posts.edit') }}</a>
      @endcan
    </nav>

    <div class="card">
      <div class="card-body">

        <h5 class="card-title">{{ $post->title }}</h5>

        <post class="card-text">{!! Illuminate\Support\Str::of($post->content)->markdown(['html_input' => 'strip']) !!}</post>
        
        <div class="small">
          @if ($post->is_published)
            <span>{{ DateHelper::isoFormat($post->published_at) }}</span>
          @else
            <span>{{ DateHelper::isoFormat($post->updated_at) }}</span>
          @endif
          <span>&mdash;</span>
          <span>{{ $post->user->name }}</span>
        </div>

        @if ($post->user->is(Auth::user()))
          @if ($post->is_published)
            <div class="mt-2">
              <span class="badge badge-light text-nowrap">{{ __('Published') }}</span>
            </div>
          @endif
        @endif

      </div>
    </div>

  </div>
@endsection