<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;


class Admin extends Model
// → On crée une classe Admin, qui représente la table "admin" dans la base de données
// Chaque ligne dans cette table correspond à un objet Admin dans le code
{
    // 🔧 On précise le nom exact de la table :
    protected $table = 'admin';
    // → Par défaut, Laravel cherche une table au pluriel (ex : "admins")
    // → Ici, on lui dit d’utiliser "admin" (au singulier)

    // ✅ On indique les colonnes autorisées à être remplies automatiquement :
    protected $fillable = ['nom_admin', 'mot_de_passe'];
    // → Ça permet d’ajouter ou modifier ces champs sans erreur de sécurité

    public $timestamps = true;
    // → Laravel va remplir automatiquement les champs "created_at" et "updated_at"
    // → Même si on ne les voit pas, ils sont gérés automatiquement
}
