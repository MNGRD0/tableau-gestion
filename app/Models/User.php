<?php

namespace App\Models;
// Ce fichier est dans "app/Models"

use Illuminate\Database\Eloquent\Factories\HasFactory;
// Permet de générer des fausses données automatiquement pour les tests

use Illuminate\Foundation\Auth\User as Authenticatable;
// Ce modèle spécial de Laravel est conçu pour gérer les utilisateurs qui peuvent se connecter (comme un client ou un admin)

use Illuminate\Notifications\Notifiable;
// Permet d'envoyer des notifications (email, etc.)

class User extends Authenticatable
// Ce modèle représente un utilisateur connecté classique (table "users")
{
    use HasFactory, Notifiable;
    // HasFactory : génère des fausses données pour les tests
    // Notifiable : l'utilisateur peut recevoir des notifications

    protected $fillable = [
        // Liste des champs qu'on peut remplir automatiquement
        'name',
        'email',
        'password',
    ];

    protected $hidden = [
        // Ces champs ne seront pas visibles quand on transforme le modèle en JSON
        'password',          // pour ne pas afficher le mot de passe
        'remember_token',    // token utilisé pour la reconnexion automatique
    ];

    protected function casts(): array
    // Permet de transformer certains champs automatiquement
    {
        return [
            'email_verified_at' => 'datetime',
            // Laravel transforme ce champ en objet date automatiquement

            'password' => 'hashed',
            // Laravel va chiffrer automatiquement le mot de passe quand on le remplit
        ];
    }
}
