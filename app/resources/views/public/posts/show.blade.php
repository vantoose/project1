@extends('layouts.templates.default')

@section('page-title', $post->title)

@section('content')
  <div class="container">

    <div class="card">
      <div class="card-body">
        <h5 class="card-title">{{ $post->title }}</h5>
        <post class="card-text">{!! Illuminate\Support\Str::of($post->content)->markdown(['html_input' => 'strip']) !!}</post>
        <div class="small">
          <span>{{ DateHelper::isoFormat($post->published_at) }}</span>
          <span>&mdash;</span>
          <span><a href="{{ route('users.show', $post->user) }}" class="text-decoration-none">{{ $post->user->name }}</a></span>
        </div>
      </div>
    </div>

  </div>
@endsection