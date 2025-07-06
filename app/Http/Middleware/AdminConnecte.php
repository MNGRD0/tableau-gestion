<?php

namespace App\Http\Middleware;
// "namespace" = indique le dossier logique de ce fichier (ici: app/Http/Middleware)

use Closure;
// "Closure" = permet de passer une fonction anonyme (ici, le reste de la requête)
use Illuminate\Http\Request;
// On importe la classe Request pour récupérer les données de la requête HTTP

class AdminConnecte
// Ce middleware vérifie si un admin est connecté avant de laisser accéder à certaines pages
{
    public function handle(Request $request, Closure $next)
    // "handle" = méthode principale appelée automatiquement par Laravel quand une requête passe par ce middleware
    // "Request $request" = représente la requête de l'utilisateur
    // "Closure $next" = fonction qui permet de continuer vers la page suivante (le prochain middleware ou le contrôleur)
    {
        if (!session()->has('admin_id')) {
            // "session()->has()" = on vérifie si la clé "admin_id" est présente dans la session
            // Si l'admin n'est pas connecté (aucune session active), alors :

            return redirect()->route('admin.connexion')->with('erreur', 'Veuillez vous connecter.');
            // On redirige vers la page de connexion admin avec un message d'erreur
        }

        return $next($request);
        // Si l'admin est connecté, on continue la requête normalement vers le contrôleur ciblé
    }
}
