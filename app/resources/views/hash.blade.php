@extends('layouts.templates.default')

@section('content')
<div class="container">
    <form method="GET" action="{{ route('hash') }}">
        <div class="form-row mb-3">
            <div class="col">
                <input type="text" name="q" class="form-control" value="{{ $text }}">
            </div>
            <div class="col-auto">
                <button type="submit" class="btn btn-primary">{{ __('Make') }}</button>
            </div>
        </div>
    </form>
    <dl class="row">
        <dt class="col-sm-3">text</dt>
        <dd class="col-sm-9 overflow-auto">{{ $text }}</dd>
        <dt class="col-sm-3">hash</dt>
        <dd class="col-sm-9 overflow-auto">{{ $hash }}</dd>
    </dl>
</div>
@endsection