<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Note extends Model
{
    use SoftDeletes;

    protected $table = 'note'; // 👈 ajoute cette ligne

    protected $fillable = [
        'client_id',
        'contenu',
        'couleur', // ✅ Très important sinon la couleur n'est pas enregistrée
    ];

    public function client()
    {
        return $this->belongsTo(Client::class);
    }
}
