<?php

namespace App\Http;
// Ce fichier se trouve dans le dossier app/Http

use Illuminate\Foundation\Http\Kernel as HttpKernel;
// On importe la classe principale "Kernel" de Laravel, qu’on renomme ici "HttpKernel"

class Kernel extends HttpKernel
// On crée notre propre classe Kernel, qui organise tous les "middleware" (filtres automatiques)
{
    protected $middleware = [
        // Ces vérifications s’appliquent à TOUTES les pages du site

        \Illuminate\Http\Middleware\HandleCors::class,
        // Autorise ou bloque les accès venant d’autres sites (sécurité externe)

        \App\Http\Middleware\TrustProxies::class,
        // Garde la vraie adresse IP du visiteur si on est derrière un serveur externe (proxy)

        \Illuminate\Http\Middleware\ValidatePostSize::class,
        // Empêche d’envoyer un formulaire trop gros (protection serveur)

        \App\Http\Middleware\TrimStrings::class,
        // Enlève les espaces inutiles autour des champs texte

        \Illuminate\Foundation\Http\Middleware\ConvertEmptyStringsToNull::class,
        // Si un champ est vide (""), il est enregistré comme null dans la base
    ];

    protected $middlewareGroups = [
        // On crée des groupes de vérifications selon le type de page (web ou API)

        'web' => [
            // Ce groupe est utilisé automatiquement pour toutes les pages web (HTML)

            \App\Http\Middleware\EncryptCookies::class,
            // Chiffre les cookies pour plus de sécurité

            \Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse::class,
            // Envoie les cookies au navigateur du visiteur

            \Illuminate\Session\Middleware\StartSession::class,
            // Lance la session (pour savoir si quelqu’un est connecté, par ex.)

            \Illuminate\View\Middleware\ShareErrorsFromSession::class,
            // Envoie les erreurs de validation vers les vues Blade (formulaires)

            \App\Http\Middleware\VerifyCsrfToken::class,
            // Protège les formulaires contre les attaques (vérifie que ça vient bien du site)

            \Illuminate\Routing\Middleware\SubstituteBindings::class,
            // Permet d’utiliser {id} dans l’URL et de récupérer directement le modèle (ex : Client, Rdv...)
        ],

        'api' => [
            // Ce groupe est utilisé pour les routes API (pas ton cas ici)

            \Laravel\Sanctum\Http\Middleware\EnsureFrontendRequestsAreStateful::class,
            // Sert à sécuriser les appels API si on utilise Sanctum (connexion via JavaScript)

            \Illuminate\Routing\Middleware\ThrottleRequests::class.':api',
            // Limite le nombre de requêtes par minute (anti-abus)

            \Illuminate\Routing\Middleware\SubstituteBindings::class,
            // Idem que plus haut : permet de relier une route à un modèle automatiquement
        ],
    ];

    protected $routeMiddleware = [
        // Ici, on déclare les "noms courts" pour appeler nos propres vérifications dans les routes

        'auth' => \App\Http\Middleware\Authenticate::class,
        // Middleware de base de Laravel pour vérifier si un utilisateur est connecté (non admin)

        'admin.connecte' => \App\Http\Middleware\AdminConnecte::class,
        // Ton propre middleware → il vérifie si l’admin est connecté grâce à la session
        // Utilisable dans une route comme ceci : ->middleware('admin.connecte')
    ];
}
