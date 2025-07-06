<?php

namespace App\Models;
// Ce fichier est dans le dossier "app/Models"

use Illuminate\Database\Eloquent\Model;
// On utilise le système Eloquent de Laravel pour parler à la base de données

use Illuminate\Database\Eloquent\SoftDeletes;
// SoftDeletes permet de supprimer une ligne sans la retirer vraiment (corbeille)

class Facture extends Model
// Ce modèle représente la table "facture" dans la base
{
    use SoftDeletes;
    // Active la fonction "corbeille" pour les factures

    protected $table = 'facture';
    // Laravel cherche par défaut une table "factures" → ici on lui dit de prendre "facture" sans s

    protected $fillable = [
        // Liste des champs qu'on a le droit de remplir automatiquement

        'client_id',            // Clé étrangère : relie à la table client
        'nom_client',           // Le nom du client (copié pour l'affichage)
        'montant',              // Montant de la facture
        'moyen_paiement',       // Ex : chèque, virement, espèces
        'echelonner',           // booléen : est-ce que c'est en plusieurs fois ?
        'statut_facture',       // Ex : payée, non payée
        'commentaire_facture'   // Zone de notes facultative
    ];

    public function client()
    // Une facture appartient à un seul client
    {
        return $this->belongsTo(Client::class);
        // "belongsTo" = relation inverse : chaque facture est liée à un client précis
    }
}
