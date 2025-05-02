@extends('layouts.app')

@section('content')
<div class="container">
  <h2 class="mb-4">Gestion des rôles</h2>

  @if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
  @endif

  <form method="POST" id="roles-form">
    @csrf
    @method('PUT')

    <table class="table table-bordered align-middle">
      <thead class="table-light">
        <tr>
          <th>Utilisateur</th>
          <th>Email</th>
          <th>Rôles</th>
          <th>Action</th>
        </tr>
      </thead>
      <tbody>
      @foreach($users as $user)
        <tr>
          <td>{{ $user->name }}</td>
          <td>{{ $user->email }}</td>
          <td>
            @foreach($roles as $role)
              <div class="form-check form-check-inline">
                <input
                  class="form-check-input"
                  type="radio"
                  name="roles[{{ $user->id }}][]"
                  value="{{ $role->id }}"
                  {{ $user->role && $user->role->id === $role->id ? 'checked' : '' }}>
                <label class="form-check-label">
                  {{ $role->label ?? ucfirst($role->name) }}
                </label>
              </div>
            @endforeach
          </td>
          <td>
            <button
              class="btn btn-sm btn-success"
              onclick="event.preventDefault();
                       document.getElementById('roles-form').action='{{ route('admin.roles.update', $user->id) }}';
                       document.getElementById('roles-form').submit();">
              Mettre à jour
            </button>

            @if($user->role)
              <a href="{{ route('admin.roles.editPermissions', $user->role->id) }}" class="btn btn-sm btn-primary ms-2">
                Gérer les permissions
              </a>
            @endif

          </td>
        </tr>
      @endforeach
      </tbody>
    </table>
  </form>

  {{ $users->links() }}
</div>
@endsection
