@extends('layouts.app') <!-- ou guest-layout selon ta structure -->

@section('content')
    <div class="container"> 
        <x-app-layout>
            <x-slot name="header">
                <h2 class="text-xl font-semibold">Tableau de bord Admin</h2>
            </x-slot>

            <div class="p-6 text-gray-900">
                Bienvenue sur la page d’administration !
            </div>
        </x-app-layout>

        {{-- Lien gestion des rôles, visible seulement aux admins --}}
        @if (auth()->user()->isAdmin())
        <div class="mb-4">
            <a href="{{ route('admin.roles.index') }}" class="btn btn-primary">
            <i class="bi bi-gear-fill me-2"></i>Gérer les rôles
            </a>
        </div>
            {{-- Vos autres widgets… --}}
        <div class="row g-4">
        {{-- … --}}
        </div>
    </div>
@endsection
