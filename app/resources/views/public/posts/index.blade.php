@extends('layouts.templates.default')

@section('content')
  <div class="container">

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
          <a href="{{ route('public.posts.show', $post) }}" class="list-group-item list-group-item-action" style="overflow-x: auto;">
            <div>{{ $post->title }}</div>
            <div class="small text-muted text-nowrap">
              <span>{{ DateHelper::isoFormat($post->published_at) }}</span>
              <span>&mdash;</span>
              <span>{{ $post->user->name }}</span>
            </div>
          </a>
        @endcan
      @endforeach
    </div>

    <div class="overflow-auto">
      {{ $posts->links() }}
    </div>

    @if (count($posts))
      <!-- Форма поиска -->
      <div class="card mb-3">
        <div class="card-body">
          <form method="GET" action="{{ route('public.posts.index') }}">
            <div class="form-row">
              <div class="col">
                <input type="text" name="q" class="form-control" value="{{ request('q') }}">
              </div>
              <div class="col-auto">
                <button type="submit" class="btn btn-primary">{{ __('routes.web.public.posts.search') }}</button>
              </div>
            </div>
          </form>
        </div>
      </div>
    @endif
    
  </div>
@endsection