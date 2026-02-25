@extends('layouts.templates.default')

@section('content')
<div class="container">
  <div class="table-responsive">
    <table class="table table-sm">
      <thead>
        <tr>
          <th scope="col">#</th>
          <th scope="col">{{ __('Name and Email') }}</th>
          <th scope="col">{{ __('Roles with permissions') }}</th>
          <th scope="col">{{ __('Direct Permissions') }}</th>
          <th scope="col">{{ __('Actions') }}</th>
        </tr>
      </thead>
      <tbody>
        @foreach ($users as $user)
          <tr>
            <th scope="row">{{ $user->id }}</th>
            <td>
              <div>{{ $user->name }}</div>
              <a href="mailto:{{ $user->email }}" class="text-decoration-none small">{{ $user->email }}</a>
            </td>
            <td>
              <dl class="row mb-0">
                @foreach($user->roles as $role)
                  <dt class="col-sm-3">
                    <span class="badge badge-primary">{{ $role->name }}</span>
                  </dt>
                  <dd class="col-sm-9">
                    @foreach($role->getPermissionNames() as $permission_name)
                      <span class="badge badge-secondary">{{ $permission_name }}</span>
                    @endforeach
                  </dd>
                @endforeach
              </dl>
            </td>
            <td>
              @foreach($user->getDirectPermissions() as $permission)
                <span class="badge badge-secondary">{{ $permission->name }}</span>
              @endforeach
            </td>
            <td>
              @can('login as')
                <a href="{{ route('admin.users.login.as', $user) }}" class="text-decoration-none">{{ __('Login as') }}</a>
              @endcan
            </td>
          </tr>
        @endforeach
      </tbody>
    </table>
  </div>
</div>
@endsection