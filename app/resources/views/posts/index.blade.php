@extends('layouts.templates.default')

@section('content')
  <div class="container">

    <nav class="nav mb-3">
      @can('create', \App\Models\Post::class)
        <a class="nav-link" href="{{ route('posts.create') }}">{{ __('Create') }}</a>
      @endcan
    </nav>

    <!-- Результаты поиска -->
    @if(request()->has('q') && !empty(request('q')))
      <div class="row">
        <div class="col-12">
          <div class="alert alert-light mb-3">
            @if($posts->total() > 0)
              <span>Найдено записей: <strong>{{ $posts->total() }}</strong> по запросу "<strong>{{ request('q') }}</strong>".</span>
            @else
              <span>По запросу "<strong>{{ request('q') }}</strong>" ничего не найдено.</span>
            @endif
          </div>
        </div>
      </div>
    @endif

    <div class="overflow-auto">
      {{ $posts->links() }}
    </div>

    <div class="list-group mb-3">
      @foreach ($posts as $post)
        @can('view', $post)
          <a href="{{ route('posts.show', $post) }}" class="list-group-item list-group-item-action d-flex" style="overflow-x: auto;">
            <div class="mr-2">
              <span>{{ $post->title }}</span>
              <small class="text-muted text-nowrap">&mdash; {{ $post->user->name }}</small>
            </div>
            <div class="d-flex flex-column flex-md-row ml-auto">
              @if ($post->is_published)
                <div class="align-self-md-center small">
                  <span class="badge badge-light text-nowrap">{{ __('Published') }}</span>
                </div>
              @endif
            </div>
          </a>
        @endcan
      @endforeach
    </div>

    <div class="overflow-auto">
      {{ $posts->links() }}
    </div>

    <!-- Форма поиска -->
    <div class="card mb-3">
      <div class="card-body">
        <form method="GET" action="{{ route('posts.index') }}">
          <div class="form-row">
            <div class="col">
              <input type="text" name="q" class="form-control" value="{{ request('q') }}">
            </div>
            <div class="col-auto">
              <button type="submit" class="btn btn-primary">{{ __('Search') }}</button>
            </div>
          </div>
        </form>
      </div>
    </div>
    
  </div>
@endsection