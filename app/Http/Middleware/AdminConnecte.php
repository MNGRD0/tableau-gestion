<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;


class AdminConnecte
{
    public function handle(Request $request, Closure $next)
    {
        if (!session()->has('admin_id')) {
            return redirect()->route('admin.connexion')->with('erreur', 'Veuillez vous connecter.');
        }

        return $next($request);
    }
}
