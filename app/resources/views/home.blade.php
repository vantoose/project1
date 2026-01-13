@extends('layouts.templates.default')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Dashboard') }}</div>

                <div class="card-body">
                    {{ __('You are logged in!') }}
                </div>
            </div>
        </div>

        <example-component class="my-4"></example-component>

        <div id="jqueryTest">JQuery Test (Click me)</div>

        

    </div>
</div>
@endsection

@push('script')
    <script type="text/javascript">
        window.addEventListener('load', function() {
            $( document ).ready(function() {

                $('div#jqueryTest').click((e) => {
                    alert('OK!')
                })

            });
        });
    </script>
@endpush

@push('head')
<style>
    div#jqueryTest {
        cursor: pointer;
    }
</style>
@endpush
