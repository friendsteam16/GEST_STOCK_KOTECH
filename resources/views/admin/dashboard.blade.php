@extends('layouts.app') <!-- ou guest-layout selon ta structure -->

@section('content')

    <x-app-layout>
        <x-slot name="header">
            <h2 class="text-xl font-semibold">Tableau de bord Admin</h2>
        </x-slot>

        <div class="p-6 text-gray-900">
            Bienvenue sur la page d’administration !
        </div>
    </x-app-layout>

@endsection
