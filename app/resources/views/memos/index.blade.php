@extends('layouts.templates.default')

@section('content')
  <div class="container">

    <form method="POST" action="{{ route('memos.store') }}" class="mb-3">
      @csrf

      <div class="form-group">
        <textarea class="form-control" id="content" name="content" placeholder="Content" rows="3">{{ old('content') }}</textarea>
      </div>

      <button type="submit" class="btn btn-primary">{{ __('routes.web.memos.store') }}</button>
    </form>

    <!-- Результаты поиска -->
    @if(request()->has('q') && !empty(request('q')))
      <div class="row">
        <div class="col-12">
          <div class="alert alert-light mb-3">
            @if($memos->total() > 0)
              <span>Найдено записей: <strong>{{ $memos->total() }}</strong> по запросу "<strong>{{ request('q') }}</strong>".</span>
            @else
              <span>По запросу "<strong>{{ request('q') }}</strong>" ничего не найдено.</span>
            @endif
          </div>
        </div>
      </div>
    @endif

    <div class="overflow-auto">
      {{ $memos->links() }}
    </div>

    <div class="list-group mb-3">
      @foreach ($memos as $memo)
        @can('view', $memo)
          <div class="list-group-item d-flex" style="overflow-x: auto;">

            <div class="mr-3">
              @if ($memo->is_valid_url)
                <a href="{{ $memo->content }}" target="_blank" class="text-decoration-none">{{ $memo->content }}</a>
              @else
                <span>{!! nl2br(e($memo->content)) !!}</span>
              @endif
            </div>

            @can('delete', $memo)
              <div class="ml-auto">
                @if (empty($memo->deleted_at))
                  <a href="{{ route('memos.destroy', $memo) }}" class="text-decoration-none text-danger"
                  onclick="event.preventDefault(); let confirmed = confirm('Delete?'); if (confirmed) { document.getElementById('delete-memo-{{ $memo->id }}').submit(); }">
                    {{ __('Delete') }}
                  </a>
                  <form id="delete-memo-{{ $memo->id }}" action="{{ route('memos.destroy', $memo) }}" method="POST" class="d-none">
                    @method('DELETE')
                    @csrf
                  </form>
                @else
                  <span class="text-danger text-nowrap">{{ DateHelper::isoFormat($memo->deleted_at) }}</span>
                @endif
              </div>
            @endcan

          </div>
        @endcan
      @endforeach
    </div>

    <div class="overflow-auto">
      {{ $memos->links() }}
    </div>

    @if (count($memos))
      <!-- Форма поиска -->
      <div class="card mb-3">
        <div class="card-body">
          <form method="GET" action="{{ route('memos.index') }}">
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
    @endif
    
  </div>
@endsection