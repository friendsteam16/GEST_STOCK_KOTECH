<nav x-data="{ open: false }" class="bg-white border-b border-gray-100 shadow-md">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between items-center h-16">
            <!-- Logo -->
            <div class="flex items-center">
                <a href="/">
                    <img src="{{ asset('images/logo.png') }}" alt="KOTech" class="h-12 w-auto" />
                </a>
            </div>

            <!-- Dropdown utilisateur -->
            @auth
                <div class="relative" x-data="{ showMenu: false }">
                    <button @click="showMenu = !showMenu"
                            class="flex items-center space-x-2 text-gray-700 hover:text-blue-600 focus:outline-none">
                        <span>👋 Bonjour, {{ Auth::user()->name }}</span>
                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0L5.293 8.707a1 1 0 010-1.414z" clip-rule="evenodd" />
                        </svg>
                    </button>

                    <!-- Menu déroulant -->
                    <div x-show="showMenu"
                         @click.away="showMenu = false"
                         class="absolute right-0 mt-2 w-48 bg-white rounded shadow-lg z-50">
                        <a href="{{ route('profile.edit') }}"
                           class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                            👤 Mon profil
                        </a>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit"
                                    class="w-full text-left px-4 py-2 text-sm text-red-600 hover:bg-red-100">
                                🚪 Se déconnecter
                            </button>
                        </form>

                        <a href="{{ route('admin.roles.index') }}" class="btn btn-primary">
                            Gérer les rôles des utilisateurs
                        </a>

                    </div>
                </div>
            @endauth
        </div>
    </div>
</nav>
