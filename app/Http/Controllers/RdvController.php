<?php

namespace App\Http\Controllers;

use App\Models\Rdv;
use App\Models\Client;
use Illuminate\Http\Request;

class RdvController extends Controller
{
    // ➤ Afficher la liste des rendez-vous
    public function index(Request $requete)
    {
        $filtre = $requete->get('filtre');

        $rdvs = Rdv::with('client');

        if ($filtre) {
            $rdvs->where('statut_rdv', $filtre);
        }

        $rdvs = $rdvs->orderBy('date', 'asc')->get();

        return view('rdv.index', compact('rdvs', 'filtre'));
    }

    // ➤ Afficher le formulaire d'ajout
    public function creer()
    {
        $clients = Client::all(); // Pour remplir le <select>
        return view('rdv.creer', compact('clients'));
    }

    // ➤ Enregistrer un nouveau rendez-vous
    public function enregistrer(Request $requete)
    {
        $requete->validate([
            'client_id' => 'required|exists:client,id',
            'date' => 'required|date',
            'lieu' => 'required|string',
            'statut_rdv' => 'required|in:à venir,en cours,passé',
            'commentaire_rdv' => 'nullable|string',
        ]);

        $client = Client::findOrFail($requete->client_id);

        Rdv::create([
            'client_id' => $client->id,
            'nom_client' => $client->nom, // ✅ Champ requis en BDD
            'date' => $requete->date,
            'lieu' => $requete->lieu,
            'statut_rdv' => $requete->statut_rdv,
            'commentaire_rdv' => $requete->commentaire_rdv,
        ]);

        return redirect()->route('rdv.index')->with('succes', 'Rendez-vous ajouté avec succès.');
    }

    public function afficher($id)
    {
        $rdv = Rdv::findOrFail($id);
        return view('rdv.afficher', compact('rdv'));
    }
    

    public function modifier($id)
    {
        $rdv = Rdv::findOrFail($id);
        $clients = Client::all(); // au cas où tu veux changer le client
        return view('rdv.modifier', compact('rdv', 'clients'));
    }

    public function supprimer($id)
    {
        $rdv = Rdv::findOrFail($id);
        $rdv->delete();

        return redirect()->route('rdv.index')->with('succes', 'Rendez-vous supprimé avec succès.');
    }

    public function mettre_a_jour(Request $requete, $id)
{
    $requete->validate([
        'client_id' => 'required|exists:client,id',
        'date' => 'required|date',
        'lieu' => 'required|string',
        'statut_rdv' => 'required|in:à venir,en cours,passé',
        'commentaire_rdv' => 'nullable|string',
    ]);

    $rdv = Rdv::findOrFail($id);
    $client = Client::findOrFail($requete->client_id);

    $rdv->update([
        'client_id' => $client->id,
        'nom_client' => $client->nom, // on met à jour aussi le nom
        'date' => $requete->date,
        'lieu' => $requete->lieu,
        'statut_rdv' => $requete->statut_rdv,
        'commentaire_rdv' => $requete->commentaire_rdv,
    ]);

    return redirect()->route('rdv.index')->with('succes', 'Rendez-vous modifié avec succès.');
}

public function supprimes()
{
    $rdvs = Rdv::onlyTrashed()->get();
    return view('rdv.supprimes', compact('rdvs'));
}

public function restaurer($id)
{
    $rdv = Rdv::onlyTrashed()->findOrFail($id);
    $rdv->restore();

    return redirect()->route('rdv.supprimes')->with('succes', 'Rendez-vous restauré.');
}

public function supprimerDefinitivement($id)
{
    $rdv = Rdv::onlyTrashed()->findOrFail($id);
    $rdv->forceDelete();

    return redirect()->route('rdv.supprimes')->with('succes', 'Rendez-vous supprimé définitivement.');
}

public function supprimerToutDefinitivement()
{
    Rdv::onlyTrashed()->forceDelete(); // ⚠️ à adapter pour Rdv ou Facture
    return redirect()->route('rdv.supprimes')->with('succes', 'Tous les rendez-vous supprimés ont été supprimés définitivement.');
}

}


