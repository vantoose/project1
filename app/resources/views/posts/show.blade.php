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
            <div class="badge badge-light text-nowrap mb-3">{{ __('Published') }}</div>
          @endif
        @endif
        <h5 class="card-title">{{ $post->title }}</h5>
        <post class="card-text">{!! Illuminate\Support\Str::of($post->content)->markdown(['html_input' => 'strip']) !!}</post>
        <div class="d-flex align-items-end">
          <div class="small">
            <span>{{ DateHelper::isoFormat($post->view_show_date) }}</span>
            <span>&mdash;</span>
            <span>{{ $post->user->name }}</span>
          </div>
          <div class="ml-auto">
            <span>[{{ $post->id }}]</span>
          </div>
        </div>
      </div>
    </div>

  </div>
@endsection