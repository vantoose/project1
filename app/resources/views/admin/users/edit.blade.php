@extends('layouts.templates.default')

@section('content')
  <div class="container">

    <nav class="nav mb-3">
      @can('delete', $user)
        <a href="{{ route('admin.users.destroy', $user) }}" class="nav-link text-danger"
          onclick="event.preventDefault(); let confirmed = confirm('Delete?'); if (confirmed) { document.getElementById('delete-user-{{ $user->id }}').submit(); }">
          {{ __('routes.web.admin.users.destroy') }}
        </a>
        <form id="delete-user-{{ $user->id }}" action="{{ route('admin.users.destroy', $user) }}" method="POST" class="d-none">
          @method('DELETE')
          @csrf
        </form>
      @endcan
    </nav>

    <div class="card mb-3">
      <div class="card-body">
        <form method="POST" action="{{ route('admin.users.update', $user) }}">
          @method('PATCH')
          @csrf
          <div class="form-group row">
            <label for="inputPassword" class="col-sm-2 col-form-label text-sm-right">Name</label>
            <div class="col-sm-10">
              <input type="text" class="form-control" id="name" name="name" value="{{ old('name', $user->name) }}">
            </div>
          </div>

          <div class="form-group row">
            <label for="inputPassword" class="col-sm-2 col-form-label text-sm-right">Email</label>
            <div class="col-sm-10">
              <input type="text" class="form-control" id="email" name="email" value="{{ old('email', $user->email) }}">
            </div>
          </div>

          <button type="submit" class="btn btn-primary">{{ __('routes.web.admin.users.update') }}</button>
        </form>
      </div>
    </div>
    
    <div class="card mb-3">
      <div class="card-body">

        <dl class="row mb-0">
          <dt class="col-sm-3">{{ __('Roles with permissions') }}</dt>
          <dd class="col-sm-9">
            @foreach($user->roles as $role)
              <dl class="row mb-0">
                <dt class="col-sm-3">
                  <span class="badge badge-primary">{{ $role->name }}</span>
                </dt>
                <dd class="col-sm-9">
                  @foreach($role->getPermissionNames() as $permission_name)
                    <span class="badge badge-secondary">{{ $permission_name }}</span>
                  @endforeach
                </dd>
              </dl>
            @endforeach
          </dd>
        </dl>

        <dl class="row mb-0">
          <dt class="col-sm-3">{{ __('Direct Permissions') }}</dt>
          <dd class="col-sm-9">
            @foreach($user->getDirectPermissions() as $permission)
              <span class="badge badge-secondary">{{ $permission->name }}</span>
            @endforeach
          </dd>
        </dl>

      </div>
    </div>
    
  </div>
@endsection