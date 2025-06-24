<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Facture extends Model
{

    use SoftDeletes;
    protected $table = 'facture';

    protected $fillable = [
        'client_id', 'nom_client', 'montant', 'moyen_paiement',
        'echelonner', 'statut_facture', 'commentaire_facture'
    ];

    public function client()
    {
        return $this->belongsTo(Client::class);
    }


}
