<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
// Cette migration crée la table "note" dans la base de données
{
    /**
     * Crée la table "note"
     */
    public function up(): void
    {
        Schema::create('note', function (Blueprint $table) {
            $table->id();
            // Clé primaire auto-incrémentée (id)

            $table->foreignId('client_id')->constrained('client')->onDelete('cascade');
            // Lien vers la table client (si le client est supprimé, ses notes le sont aussi)

            $table->string('contenu');
            // Texte de la note (obligatoire)

            $table->string('couleur')->default('#ffff88');
            // Couleur de la note (style post-it)
            // On utilise un champ texte pour stocker un code couleur (ex : #ffff88 pour jaune clair)
            // "default" = si aucune couleur n'est choisie, on met automatiquement ce jaune clair par défaut

            $table->timestamps();
            // Crée "created_at" et "updated_at"

            $table->softDeletes();
            // Permet la suppression logique (corbeille)
        });
    }

    /**
     * Supprime la table "note" si elle existe
     */
    public function down(): void
    {
        Schema::dropIfExists('note');
        // Supprime la table si elle existe (utile pour rollback)
    }
};
