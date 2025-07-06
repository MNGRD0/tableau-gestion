<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
// Cette classe est une migration anonyme (créée automatiquement par Laravel)
// Elle permet de créer ou supprimer des tables dans la base de données
{
    /**
     * Exécute la migration (crée les tables)
     */
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {
            // Crée une table "users" avec les champs suivants :

            $table->id();
            // Clé primaire (id auto-incrémentée)

            $table->string('name');
            // Nom de l'utilisateur

            $table->string('email')->unique();
            // Email unique (pas de doublon possible)

            $table->timestamp('email_verified_at')->nullable();
            // Date vérifiant si l'utilisateur a confirmé son email (peut être vide)

            $table->string('password');
            // Mot de passe (crypté)

            $table->rememberToken();
            // Token pour que Laravel se souvienne de l'utilisateur ("se souvenir de moi")

            $table->timestamps();
            // Crée automatiquement "created_at" et "updated_at"
        });

        Schema::create('password_reset_tokens', function (Blueprint $table) {
            // Crée la table pour stocker les liens de réinitialisation de mot de passe

            $table->string('email')->primary();
            // Email = clé principale

            $table->string('token');
            // Token unique envoyé par mail

            $table->timestamp('created_at')->nullable();
            // Date de création du token (peut être vide)
        });

        Schema::create('sessions', function (Blueprint $table) {
            // Crée la table qui stocke les sessions des utilisateurs connectés

            $table->string('id')->primary();
            // ID de session (chaîne unique)

            $table->foreignId('user_id')->nullable()->index();
            // ID de l'utilisateur connecté (peut être vide), avec index pour accélérer les recherches

            $table->string('ip_address', 45)->nullable();
            // Adresse IP de l'utilisateur

            $table->text('user_agent')->nullable();
            // Navigateur utilisé (ex : Chrome, Firefox...)

            $table->longText('payload');
            // Données de la session (chiffres, variables stockées...)

            $table->integer('last_activity')->index();
            // Date de la dernière activité (timestamp)
        });
    }

    //Annule la migration (supprime les tables) : La fonction down() sert à annuler une migration.
    // Si je fais un retour en arrière (rollback), 
    // Laravel utilise cette fonction pour supprimer les tables qu’il a créées.
    
    public function down(): void
    {
        Schema::dropIfExists('users');
        Schema::dropIfExists('password_reset_tokens');
        Schema::dropIfExists('sessions');
        
    }
};
