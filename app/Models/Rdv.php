<?php

namespace App\Models;
// Ce fichier est dans "app/Models" : c'est un modèle Eloquent de Laravel

use Illuminate\Database\Eloquent\Model;
// On utilise le système Eloquent de Laravel pour parler à la base de données

use Illuminate\Database\Eloquent\SoftDeletes;
// SoftDeletes permet de mettre en corbeille sans supprimer vraiment

class Rdv extends Model
// Ce modèle représente la table "rdv" dans la base
{
    use SoftDeletes;
    // Active la suppression logique (corbeille)

    protected $table = 'rdv';
    // Laravel cherche par défaut "rdvs", donc on lui dit que la table est "rdv" sans "s"

    protected $fillable = [
        // Liste des champs qu'on peut remplir automatiquement

        'client_id',        // Lien avec le client concerné
        'nom_client',       // Copie du nom pour l'affichage rapide
        'date',             // Date du rendez-vous
        'lieu',             // Lieu du rendez-vous
        'statut_rdv',       // État : à venir, en cours, passé
        'commentaire_rdv',  // Note facultative
    ];

    public function client()
    // Un rendez-vous appartient à un seul client
    {
        return $this->belongsTo(Client::class);
        // "belongsTo" = relation 1 seul client associé au rendez-vous
    }
}
