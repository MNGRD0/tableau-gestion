<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
// C'est une migration anonyme : elle permet de créer ou supprimer la table "admin" dans la base de données
{
    /**
     * Crée la table "admin" dans la base de données
     */
    public function up(): void
    {
        Schema::create('admin', function (Blueprint $table) {
            $table->id();
            // Crée un champ "id" auto-incrémenté (clé primaire)

            $table->string('nom_admin')->unique();
            // Champ pour le nom de l'admin, il doit être unique (pas deux fois le même nom)

            $table->string('mot_de_passe');
            // Champ pour le mot de passe (crypté)

            $table->timestamps();
            // Crée automatiquement les champs "created_at" et "updated_at"
        });
    }

    //Supprime la table "admin" si elle existe (utile si on veut annuler la migration avec 
    // "php artisan migrate:rollback")
    public function down(): void
    {
        Schema::dropIfExists('admin');
        // Supprime la table "admin" uniquement si elle existe dans la base
    }
};
