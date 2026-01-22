@extends('layouts.templates.default')

@section('content')
<div class="container">
  <div class="table-responsive">
    <table class="table table-sm">
      <thead>
        <tr>
          <th scope="col">#</th>
          <th scope="col">{{ __('Name') }}</th>
          <th scope="col">{{ __('Email') }}</th>
          <th scope="col">{{ __('Actions') }}</th>
        </tr>
      </thead>
      <tbody>
        @foreach ($users as $user)
          <tr>
            <th scope="row">{{ $user->id }}</th>
            <td>{{ $user->name }}</td>
            <td><a href="mailto:{{ $user->email }}" class="text-decoration-none">{{ $user->email }}</a></td>
            <td><a href="{{ route('admin.users.login_as', $user) }}" class="text-decoration-none">{{ __('Login as') }}</a></td>
          </tr>
        @endforeach
      </tbody>
    </table>
  </div>
</div>
@endsection