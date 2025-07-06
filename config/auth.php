<?php

// Ce fichier s'appelle "auth.php" et il est dans config/auth.php
// Il sert à dire à Laravel comment gérer l'authentification (connexion, déconnexion, utilisateur, mot de passe...)
// Il est directement utilisé par les fichiers de connexion (middleware, guard, Auth::check, etc.)
// C'est comme une "fiche de réglage" pour que Laravel sache comment gérer les sessions et les utilisateurs

return [

    // 🔑 Partie 1 : Défauts de connexion (le guard utilisé, et le mot de passe)
    'defaults' => [
        'guard' => env('AUTH_GUARD', 'web'),
        // Le système utilisé par défaut pour savoir si quelqu'un est connecté (ici : "web")

        'passwords' => env('AUTH_PASSWORD_BROKER', 'users'),
        // Le système utilisé pour gérer les réinitialisations de mot de passe (ici pour les users)
    ],

    // 🚪 Partie 2 : Les guards (les "portiers")
    // Un guard définit "comment" Laravel vérifie si quelqu'un est connecté
    'guards' => [
        'web' => [
            'driver' => 'session', // Laravel utilise les sessions PHP pour se souvenir qui est connecté
            'provider' => 'users', // Il va chercher l'utilisateur via le provider "users"
        ],
    ],

    // 🤖 Partie 3 : Les providers (où chercher les utilisateurs)
    // Le provider dit à Laravel quel modèle utiliser pour aller chercher un utilisateur
    'providers' => [
        'users' => [
            'driver' => 'eloquent', // Laravel utilise Eloquent pour accéder aux données
            'model' => env('AUTH_MODEL', App\Models\User::class),
            // Il utilise le modèle User (app/Models/User.php)
        ],

        // Exemple si on veut utiliser une table sans modèle Eloquent :
        // 'users' => [
        //     'driver' => 'database',
        //     'table' => 'users',
        // ],
    ],

    // 🔐 Partie 4 : Réinitialisation des mots de passe
    'passwords' => [
        'users' => [
            'provider' => 'users', // On utilise le provider "users"
            'table' => env('AUTH_PASSWORD_RESET_TOKEN_TABLE', 'password_reset_tokens'),
            // Table où les tokens de réinitialisation sont stockés
            'expire' => 60,   // Durée de validité du lien (en minutes)
            'throttle' => 60, // Temps d'attente entre deux demandes de lien
        ],
    ],

    // ⏱ Partie 5 : Durée avant de redemander le mot de passe
    'password_timeout' => env('AUTH_PASSWORD_TIMEOUT', 10800),
    // Durée avant que Laravel redemande le mot de passe (en secondes). Ici : 3 heures

];
