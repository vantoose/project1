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
          <a href="{{ route('posts.show', $post) }}" class="list-group-item list-group-item-action" style="overflow-x: auto;">
            @if ($post->user->is(Auth::user()))
              @if ($post->is_published)
                <div class="mb-2">
                  <span class="badge badge-light text-nowrap">{{ __('Published') }}</span>
                </div>
              @endif
            @endif
            <div class="d-flex align-items-center">

              <div class="mr-2">
                <div>{{ $post->title }}</div>
                <div class="small text-muted text-nowrap">
                  @if ($post->is_published)
                    <span>{{ DateHelper::isoFormat($post->published_at) }}</span>
                  @else
                    <span>{{ DateHelper::isoFormat($post->updated_at) }}</span>
                  @endif
                  <span>&mdash;</span>
                  <span>{{ $post->user->name }}</span>
                </div>
              </div>
              
              <div class="ml-auto">
                <small>[{{ $post->id }}]</small>
              </div>

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