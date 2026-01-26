@extends('layouts.templates.default')

@section('page-title', $post->title)

@section('content')
  <div class="container">

    <nav class="nav mb-3">
      @can('update', $post)
        <a class="nav-link" href="{{ route('posts.edit', $post) }}">{{ __('Edit') }}</a>
      @endcan
    </nav>

    <div class="card">
      <div class="card-body">

        @if ($post->user->is(Auth::user()))
          @if ($post->is_published)
            <div class="mb-3">
              <span class="badge badge-light text-nowrap">{{ __('Published') }}</span>
            </div>
          @endif
        @endif

        <h5 class="card-title">{{ $post->title }}</h5>

        <post class="card-text">{!! Illuminate\Support\Str::of($post->content)->markdown(['html_input' => 'strip']) !!}</post>
        
        <div class="d-flex align-items-center">
          <div class="mr-auto">
            <div class="small">
              @if ($post->is_published)
                <span>{{ DateHelper::isoFormat($post->published_at) }}</span>
              @else
                <span>{{ DateHelper::isoFormat($post->updated_at) }}</span>
              @endif
              <span>&mdash;</span>
              <span>{{ $post->user->name }}</span>
            </div>
          </div>
          <div class="">
            <small>[{{ $post->id }}]</small>
          </div>
        </div>

      </div>
    </div>

  </div>
@endsection