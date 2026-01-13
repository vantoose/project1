@extends('layouts.templates.default')

@section('content')
<div class="container">
    <div class="small text-muted mb-3">?q={{ $text }}</div>
    <dl class="row">
        <dt class="col-sm-3">text</dt>
        <dd class="col-sm-9">{{ $text }}</dd>
        <dt class="col-sm-3">hash</dt>
        <dd class="col-sm-9">{{ $hash }}</dd>
    </dl>
</div>
@endsection