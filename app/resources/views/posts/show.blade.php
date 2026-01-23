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
        <h5 class="card-title">{{ $post->title }}</h5>
        <post class="card-text">{!! Illuminate\Support\Str::of($post->content)->markdown(['html_input' => 'strip']) !!}</post>
        <div class="text-nowrap">
          <small>{{ DateHelper::isoFormat($post->created_at) }}</small>
          <small>
            <span>&mdash;</span>
            <a href="{{ route('posts.indexUser', $post->user) }}">{{ $post->user->name }}</a>
          </small>
        </div>
      </div>
    </div>

  </div>
@endsection