<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Rdv extends Model
{

    use SoftDeletes;
    protected $table = 'rdv';

    protected $fillable = [
        'client_id',
        'nom_client',
        'date',
        'lieu',
        'statut_rdv',
        'commentaire_rdv',
    ];

    public function client()
    {
        return $this->belongsTo(Client::class);
    }

   
}
