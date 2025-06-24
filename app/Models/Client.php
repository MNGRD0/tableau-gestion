<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Client extends Model
{

    use SoftDeletes;
    // Je dis à Laravel que ma table s'appelle "client"
    protected $table = 'client';

    // Je dis à Laravel quels champs je peux enregistrer automatiquement
    protected $fillable = [
        'nom',
        'email_client',
        'adresse_client',
        'cp_client',
        'ville_client',
        'commentaire_client',
        'telephone_client'];

    // Un client peut avoir plusieurs rendez-vous
    public function rdvs()
    {
        return $this->hasMany(Rdv::class);
    }

    // Un client peut avoir plusieurs factures
    public function factures()
    {
        return $this->hasMany(Facture::class);
    }

    // Un client peut avoir plusieurs notes
    public function notes()
    {
        return $this->hasMany(Note::class);
    }

    
    
}
