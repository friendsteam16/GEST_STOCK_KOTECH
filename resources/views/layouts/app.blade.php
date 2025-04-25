<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'GSTOCK KOTECH') }}</title>

        <!-- Bootstrap CSS -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

        <!-- Icônes -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts Laravel vite -->
        @vite(['resources/css/app.css', 'resources/js/app.js']) 
    </head>

    
    <style>
        .card-hover {
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .card-hover:hover {
            transform: translateY(-5px);
            box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15);
        }
    </style>

    <body class="font-sans antialiased">
        <div class="min-h-screen bg-gray-100">

            <!-- Top Navigation -->
            @include('layouts.navigation')

            <!-- Auth bar -->
            @auth
                <div class="p-2 text-end me-4">
                    <form method="POST" action="{{ route('logout') }}" class="d-inline">
                        @csrf
            @endauth

            <br>
            <br>

            <!-- Sidebar -->
            <nav class="bg-gradient-to-r from-white via-blue-100 to-white border-b border-gray-300 shadow">
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                    <ul class="flex justify-center space-x-6 divide-x divide-gray-300 py-3 text-sm font-medium text-gray-700">
                        
                        <li class="px-4 flex items-center space-x-2">
                            <i class="fas fa-tachometer-alt text-blue-600"></i>
                            <a href="{{ route('dashboard') }}">Tableau de bord</a>
                        </li>

                        <li class="px-4 flex items-center space-x-2">
                            <i class="fas fa-cube text-blue-600"></i>
                            <a href="{{ route('produits.index') }}">Produits</a>
                        </li>

                        <li class="px-4 flex items-center space-x-2">
                            <i class="fas fa-tags text-blue-600"></i>
                            <a href="{{ route('categories.index') }}">Catégories</a>
                        </li>

                        <li class="px-4 flex items-center space-x-2">
                            <i class="fas fa-truck text-blue-600"></i>
                            <a href="{{ route('fournisseurs.index') }}">Fournisseurs</a>
                        </li>

                        <li class="px-4 flex items-center space-x-2">
                            <i class="fas fa-arrow-down text-blue-600"></i>
                            <a href="{{ route('entrees.index') }}">Entrées</a>
                        </li>

                        <li class="px-4 flex items-center space-x-2">
                            <i class="fas fa-arrow-up text-blue-600"></i>
                            <a href="{{ route('sorties.index') }}">Sorties</a>
                        </li>

                        <li class="px-4 flex items-center space-x-2">
                            <i class="fas fa-file-alt text-blue-600"></i>
                            <a href="{{ route('articles.index') }}">Articles</a>
                        </li>

                    </ul>
                </div>
            </nav>


            <!-- Page Heading -->
            @isset($header)
                <header class="bg-white shadow">
                    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                        {{ $header }}
                    </div>
                </header>
            @endisset

            <!-- Page Content -->
            <main class="p-4">
                @yield('content')
            </main>
        </div>
    </body>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</html>
