@extends('layouts.templates.default')

@section('content')
  <div class="container">

    <form method="POST" action="{{ route('posts.store') }}" class="mb-3">
      @csrf
      <div class="form-group">
        <input type="text" class="form-control" id="title" name="title" placeholder="Title" value="{{ old('title') }}">
      </div>
      
      <div class="form-group">
        <textarea class="form-control" id="content" name="content" placeholder="Content" rows="5">{{ old('content') }}</textarea>
        <small class="form-text text-muted">Markdown guide: <a href="https://www.markdownguide.org/basic-syntax/" target="_blank">Basic Syntax</a></small>
      </div>

      <button type="submit" class="btn btn-primary">{{ __('Store') }}</button>
    </form>
    
  </div>
@endsection