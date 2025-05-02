@extends('layouts.app')

@section('content')
<div class="container">
    <h2 class="mb-4">Ajouter une nouvelle permission</h2>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('admin.permissions.store') }}" method="POST">
        @csrf

        <div class="mb-3">
            <label for="name" class="form-label">Nom de la permission</label>
            <input type="text" name="name" id="name" class="form-control" required>
        </div>

        <button type="submit" class="btn btn-primary">Ajouter</button>
        <a href="{{ route('admin.roles.index') }}" class="btn btn-secondary">Annuler</a>
    </form>
</div>
@endsection
