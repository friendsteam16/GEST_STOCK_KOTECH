<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'GSTOCK KOTECH') }}</title>

    <!-- Styles -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        * {
            box-sizing: border-box;
        }

        html, body {
            height: 100%;
            margin: 0;
            overflow: hidden;
        }

        .topbar {
            height: 64px;
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            background-color: white;
            z-index: 50;
        }

        .sidebar {
            position: fixed;
            top: 64px;
            left: 0;
            bottom: 0;
            width: 250px;
            background-color: #1f2937;
            color: white;
            overflow-y: auto;
            padding: 1rem;
        }

        .main-content {
            margin-left: 250px;
            margin-top: 64px;
            height: calc(100vh - 64px);
            overflow-y: auto;
            padding: 2rem;
        }
    </style>
</head>

<body class="bg-gray-100 dark:bg-gray-900 text-gray-900 dark:text-white">

    <!-- Topbar -->
    <div class="topbar shadow">
        @include('layouts.navigation')
    </div>

    <!-- Sidebar -->
    <aside class="sidebar">
        <nav class="space-y-2">
            <a href="/dashboard" class="d-block py-2 px-3 rounded hover:bg-gray-700">Tableau de bord</a>
            <a href="{{ route('categories.index') }}" class="d-block py-2 px-3 rounded hover:bg-gray-700">Catégories</a>
            <a href="{{ route('fournisseurs.index') }}" class="d-block py-2 px-3 rounded hover:bg-gray-700">Fournisseurs</a>
            <a href="{{ route('produits.index') }}" class="d-block py-2 px-3 rounded hover:bg-gray-700">Produits</a>
            <a href="{{ route('articles.index') }}" class="d-block py-2 px-3 rounded hover:bg-gray-700">Articles</a>
            <a href="{{ route('entrees.index') }}" class="d-block py-2 px-3 rounded hover:bg-gray-700">Entrées</a>
            <a href="{{ route('sorties.index') }}" class="d-block py-2 px-3 rounded hover:bg-gray-700">Sorties</a>
            <a href="{{ route('invoices.create') }}" class="d-block py-2 px-3 rounded hover:bg-gray-700">Facture</a>
        </nav>

        <form method="POST" action="{{ route('logout') }}" class="mt-4 px-2">
            @csrf
            <button type="submit" class="w-100 text-start py-2 px-3 bg-danger text-white rounded">
                <i class="fas fa-sign-out-alt me-2"></i> Déconnexion
            </button>
        </form>

        <button onclick="document.documentElement.classList.toggle('dark')" class="w-100 text-start py-2 px-3 mt-4 bg-secondary rounded text-white">
            🌜 Mode sombre
        </button>
    </aside>

    <!-- Main content -->
    <main class="main-content">
        @yield('content')
    </main>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
