<?php

namespace App\Models;
// Ce fichier est dans le dossier "app/Models"

use Illuminate\Database\Eloquent\Model;
// On utilise le système Eloquent de Laravel pour manipuler la base de données

use Illuminate\Database\Eloquent\SoftDeletes;
// SoftDeletes permet de supprimer une note sans la retirer vraiment (corbeille)

class Note extends Model
// Ce modèle représente la table "note" dans la base
{
    use SoftDeletes;
    // Active la suppression logique (corbeille)

    protected $table = 'note';
    // On dit à Laravel que la table s'appelle "note" (sinon il chercherait "notes")

    protected $fillable = [
        // Liste des champs qu'on peut remplir automatiquement

        'client_id',  // ID du client associé à la note
        'contenu',    // Le texte écrit dans la note
        'couleur',    // La couleur choisie (ex: jaune, vert...) pour l'affichage style post-it
    ];

    public function client()
    // Une note appartient à un seul client
    {
        return $this->belongsTo(Client::class);
        // "belongsTo" = cette note est liée à un seul client précis
    }
}
