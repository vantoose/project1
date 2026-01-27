@extends('layouts.templates.default')

@section('page-title', $post->title)

@section('content')
  <div class="container">

    <div class="card">
      <div class="card-body">

        <h5 class="card-title">{{ $post->title }}</h5>

        <post class="card-text">{!! Illuminate\Support\Str::of($post->content)->markdown(['html_input' => 'strip']) !!}</post>
        
        <div class="d-flex align-items-center">
          <div class="mr-auto">
            <div class="small">
              <span>{{ DateHelper::isoFormat($post->published_at) }}</span>
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