@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Gestion des rôles</h2>

    @if(session('success'))
      <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <form method="POST" action="{{ route('admin.roles.update', 0) }}" id="roles-form">
      @csrf
      @method('PUT')
      <table class="table table-bordered">
        <thead>
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
                <label class="me-2">
                  <input
                    type="checkbox"
                    name="roles[{{ $user->id }}][]"
                    value="{{ $role->id }}"
                    {{ $user->roles->contains($role) ? 'checked' : '' }}>
                  {{ $role->label ?? $role->name }}
                </label>
              @endforeach
            </td>
            <td>
              <button
                class="btn btn-sm btn-success"
                onclick="event.preventDefault(); document.getElementById('roles-form').action='{{ route('admin.roles.update', $user->id) }}'; document.getElementById('roles-form').submit();">
                Mettre à jour
              </button>
            </td>
          </tr>
        @endforeach
        </tbody>
      </table>
    </form>

    {{ $users->links() }}
</div>
@endsection
