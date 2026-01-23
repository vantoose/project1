@extends('layouts.templates.default')

@section('content')
  <div class="container">

    <form method="POST" action="{{ route('posts.update', $post) }}" class="mb-3">
      @method('PATCH')
      @csrf
      <div class="form-group">
        <input type="text" class="form-control" id="title" name="title" placeholder="Title" value="{{ old('title', $post->title) }}">
      </div>
      
      <div class="form-group">
        <textarea class="form-control" id="content" name="content" placeholder="Text" rows="5">{{ old('content', $post->content) }}</textarea>
        <small class="form-text text-muted"><a href="https://www.markdownguide.org/basic-syntax/" target="_blank">Markdown guide - Basic Syntax</a></small>
      </div>

      <button type="submit" class="btn btn-primary">{{ __('Update') }}</button>
    </form>
    
  </div>
@endsection