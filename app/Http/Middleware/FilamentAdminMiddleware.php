<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class FilamentAdminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = auth()->user();

        // Vérifie si l'utilisateur est authentifié et a un rôle autorisé
        if (!$user || !$user->hasRole(['admin', 'pilot'])) {
            abort(403, 'Accès refusé.');
        }

        return $next($request);
    }
}
