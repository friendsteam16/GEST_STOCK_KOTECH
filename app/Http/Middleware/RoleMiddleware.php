<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string  $role
     * @return mixed
     */
    public function handle(Request $request, Closure $next, string $role)
    {
        // Vérifie si l'utilisateur est connecté
        if (!Auth::check()) {
            abort(403, 'Accès refusé. Utilisateur non authentifié.');
        }

        $user = Auth::user();

        // Vérifie si l'utilisateur a un rôle correspondant
        if ($user->role && $user->role->name === $role) {
            return $next($request);
        }

        // Sinon, accès refusé
        abort(403, 'Accès refusé. Rôle requis : ' . $role);
    }
}
