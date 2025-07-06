<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
// Cette classe permet de créer ou supprimer la table "rdv" (rendez-vous)
{
    /**
     * Crée la table "rdv" dans la base de données
     */
    public function up(): void
    {
        Schema::create('rdv', function (Blueprint $table) {
            $table->id();
            // ID auto-incrémenté (clé primaire)

            $table->foreignId('client_id')->constrained('client')->onDelete('cascade');
            // Clé étrangère vers la table "client"
            // "constrained('client')" = fait le lien avec la table client
            // "onDelete('cascade')" = si le client est supprimé, ses rendez-vous le sont aussi automatiquement

            $table->string('nom_client');
            // Copie du nom du client (utile pour l'affichage)

            $table->dateTime('date');
            // Date et heure du rendez-vous

            $table->string('lieu');
            // Lieu du rendez-vous

            $table->enum('statut_rdv', ['à venir', 'en cours','passé']);
            // Statut du rendez-vous : obligatoire et limité à ces 3 options

            $table->string('commentaire_rdv')->nullable();
            // Commentaire facultatif (nullable = peut être vide)

            $table->timestamps();
            // Crée "created_at" et "updated_at" automatiquement

            $table->softDeletes();
            // Permet la suppression logique (corbeille)
        });
    }

    /**
     * Supprime la table "rdv" si elle existe
     */
    public function down(): void
    {
        Schema::dropIfExists('rdv');
        // Supprime la table uniquement si elle existe (utile pour rollback)
    }
};
