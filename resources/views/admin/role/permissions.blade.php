@extends('layouts.app')

@section('content')
<div class="container">
    <h2 class="mb-4">Gérer les permissions pour le rôle : <strong>{{ $role->name }}</strong></h2>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    {{-- Formulaire d’ajout de permission --}}
    <form action="{{ route('admin.permissions.store') }}" method="POST" class="mb-4">
        @csrf
        <div class="row align-items-end">
            <div class="col-md-6">
                <label for="new_permission" class="form-label">Nouvelle permission</label>
                <input type="text" name="name" id="new_permission" class="form-control" placeholder="ex: manage_reports" required>
            </div>
            <div class="col-md-4">
                <button class="btn btn-success">Ajouter la permission</button>
            </div>
        </div>
    </form>

    @php
        $labels = [
            'manage_users'      => 'Gérer les utilisateurs',
            'view_dashboard'    => 'Voir le tableau de bord',
            'manage_products'   => 'Gérer les produits',
            'manage_categories' => 'Gérer les catégories',
            'manage_suppliers'  => 'Gérer les fournisseurs',
            'manage_entries'    => 'Gérer les entrées',
            'manage_exits'      => 'Gérer les sorties',
            'export_data'       => 'Exporter les données',
        ];
    @endphp

    {{-- Formulaire de mise à jour des permissions --}}
    <form action="{{ route('admin.roles.updatePermissions', $role) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="row">
            @foreach($permissions as $permission)
                <div class="col-md-4">
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="checkbox"
                            name="permissions[]" value="{{ $permission->id }}"
                            id="permission_{{ $permission->id }}"
                            {{ $role->permissions->contains($permission) ? 'checked' : '' }}>
                        <label class="form-check-label" for="permission_{{ $permission->id }}">
                            {{ $labels[$permission->name] ?? __($permission->name) }}
                        </label>
                    </div>
                </div>
            @endforeach
        </div>
        <button type="submit" class="btn btn-primary mt-4">Mettre à jour les permissions</button>
        <a href="{{ route('admin.roles.index') }}" class="btn btn-secondary mt-4">Retour</a>
    </form>
</div>
@endsection
