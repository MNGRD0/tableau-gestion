<?php

namespace App\Models;
// Ce fichier est dans le dossier "app/Models"

use Illuminate\Database\Eloquent\Model;
// On utilise le système Eloquent de Laravel pour parler à la base de données

use Illuminate\Database\Eloquent\SoftDeletes;
// On importe SoftDeletes = permet de supprimer des données "sans les effacer vraiment" (corbeille)

class Client extends Model
// On crée un modèle Client qui représente la table "client" dans la base
{
    use SoftDeletes;
    // Active la fonction corbeille : les lignes supprimées ne sont pas effacées vraiment

    protected $table = 'client';
    // On dit à Laravel d'utiliser la table "client" (car sinon il chercherait "clients" avec un s)

    protected $fillable = [
        // Liste des champs qu'on a le droit de remplir automatiquement

        'nom',
        'email_client',
        'adresse_client',
        'cp_client',
        'ville_client',
        'commentaire_client',
        'telephone_client',
        'mot_de_passe_client', // Champ utilisé si le client peut se connecter
    ];

    public function rdvs()
    // Cette fonction dit qu'un client peut avoir plusieurs rendez-vous
    {
        return $this->hasMany(Rdv::class);
        // "hasMany" = relation 1 à plusieurs. Un client peut avoir plein de rdvs
    }

    public function factures()
    // Cette fonction dit qu'un client peut avoir plusieurs factures
    {
        return $this->hasMany(Facture::class);
    }

    public function notes()
    // Cette fonction dit qu'un client peut avoir plusieurs notes
    {
        return $this->hasMany(Note::class);
    }
}
