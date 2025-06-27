<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Admin extends Model
{
    // Force Laravel à utiliser la table 'admin' au singulier
    protected $table = 'admin';

    // Autorise l'insertion de ces champs
    protected $fillable = ['nom_admin', 'mot_de_passe'];

    // Laravel n'utilise pas de mots de passe chiffrés automatiquement
    public $timestamps = true;
}
