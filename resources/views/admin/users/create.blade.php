<x-app-layout>
    <x-slot name="header">Créer un utilisateur</x-slot>

    <form action="{{ route('admin.users.store') }}" method="POST" class="max-w-xl mx-auto mt-6 space-y-4">
        @csrf

        <div>
            <label for="name">Nom</label>
            <input type="text" name="name" class="w-full border rounded p-2" required>
        </div>

        <div>
            <label for="email">Email</label>
            <input type="email" name="email" class="w-full border rounded p-2" required>
        </div>

        <div>
            <label for="password">Mot de passe</label>
            <input type="password" name="password" class="w-full border rounded p-2" required>
        </div>

        <div>
            <label for="password_confirmation">Confirmer le mot de passe</label>
            <input type="password" name="password_confirmation" class="w-full border rounded p-2" required>
        </div>

        <div>
            <label for="role_id">Rôle</label>
            <select name="role_id" class="w-full border rounded p-2" required>
                @foreach ($roles as $role)
                    <option value="{{ $role->id }}">{{ ucfirst($role->nom) }}</option>
                @endforeach
            </select>
        </div>

        <button class="bg-blue-600 text-white px-4 py-2 rounded">Créer</button>
    </form>
</x-app-layout>
