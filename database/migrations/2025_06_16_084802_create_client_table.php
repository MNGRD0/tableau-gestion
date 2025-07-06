<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Méthode qui s'exécute lors de la migration.
     */
    public function up(): void
    {
        Schema::create('client', function (Blueprint $table) {
            $table->id(); // Clé primaire auto-incrémentée
            $table->string('nom'); // Nom du client
            $table->string('email_client')->unique(); // Email du client (doit être unique pour pouvoir se connecter)
            $table->string('mot_de_passe_client'); // Mot de passe du client (sera hashé)
            $table->string('telephone_client', 17); // Numéro de téléphone
            $table->string('adresse_client'); // Adresse complète
            $table->string('cp_client', 10); // Code postal
            $table->string('ville_client'); // Ville
            $table->string('commentaire_client')->nullable(); // Champ optionnel pour commentaires
            $table->timestamps(); // Champs created_at et updated_at automatiquement gérés par Laravel
            $table->softDeletes(); // Ajoute un champ deleted_at pour la suppression logique
        });
    }

    /**
     * Méthode qui s'exécute pour annuler la migration (rollback).
     */
    public function down(): void
    {
        Schema::dropIfExists('client'); // Supprime la table client si elle existe
    }
};
