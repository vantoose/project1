@extends('layouts.templates.default')

@section('content')
  <div class="container">

    <nav class="nav mb-3">
      @can('delete', $post)
        <a href="{{ route('posts.destroy', $post) }}" class="nav-link text-danger"
          onclick="event.preventDefault(); let confirmed = confirm('Delete?'); if (confirmed) { document.getElementById('delete-post-{{ $post->id }}').submit(); }">
          {{ __('routes.web.posts.destroy') }}
        </a>
        <form id="delete-post-{{ $post->id }}" action="{{ route('posts.destroy', $post) }}" method="POST" class="d-none">
          @method('DELETE')
          @csrf
        </form>
      @endcan
    </nav>

    <form method="POST" action="{{ route('posts.update', $post) }}" class="mb-3">
      @method('PATCH')
      @csrf
      <div class="form-group">
        <input type="text" class="form-control" id="title" name="title" placeholder="Title" value="{{ old('title', $post->title) }}">
      </div>
      
      <div class="form-group">
        <textarea class="form-control" id="content" name="content" placeholder="Text" rows="12">{{ old('content', $post->content) }}</textarea>
        <small class="form-text text-muted"><a href="https://www.markdownguide.org/basic-syntax/" target="_blank">Markdown guide - Basic Syntax</a></small>
      </div>

      <div class="form-group form-check">
        <input type="checkbox" class="form-check-input" id="is_published" name="is_published" value="1" @if (old('is_published', $post->is_published)) checked @endif>
        <label class="form-check-label" for="is_published">{{ __('Is published') }}</label>
      </div>

      <button type="submit" class="btn btn-primary">{{ __('routes.web.posts.update') }}</button>
    </form>
    
  </div>
@endsection