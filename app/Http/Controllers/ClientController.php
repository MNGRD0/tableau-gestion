<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Client;
use Illuminate\Support\Facades\Route;

class ClientController extends Controller
{
    public function index(Request $request)
    {
        $tri = $request->get('tri');
        $mode = $request->get('mode'); // "tout" ou null

        $clients = Client::query();

        if ($tri === 'a_z') {
            $clients->orderBy('nom', 'asc');
        } elseif ($tri === 'z_a') {
            $clients->orderBy('nom', 'desc');
        } elseif ($tri === 'recent') {
            $clients->orderBy('created_at', 'desc');
        } elseif ($tri === 'ancien') {
            $clients->orderBy('created_at', 'asc');
        }

        // ✅ Si "mode=tout", on affiche tout, sinon on limite à 10
        $clients = $mode === 'tout' ? $clients->get() : $clients->limit(10)->get();

        return view('clients.index', compact('clients', 'tri', 'mode'));
    }

    public function creer()
    {
        return view('clients.creer');
    }

    public function enregistrer(Request $requete)
    {
        $requete->validate([
            'nom' => 'required|string',
            'email' => 'required|email',
            'adresse' => 'required|string',
            'code_postal' => 'required|string',
            'ville' => 'required|string',
            'note' => 'nullable|string',
            'telephone' => 'required|string',
        ]);

        Client::create([
            'nom' => $requete->nom,
            'email_client' => $requete->email,
            'adresse_client' => $requete->adresse,
            'cp_client' => $requete->code_postal,
            'ville_client' => $requete->ville,
            'commentaire_client' => $requete->note,
            'telephone_client' => $requete->telephone,
        ]);

        return redirect()->route('clients.index')->with('succes', 'Client ajouté avec succès.');
    }

    public function afficher($id)
    {
        $client = Client::findOrFail($id);
        return view('clients.afficher', compact('client'));
    }

    public function modifier($id)
    {
        $client = Client::findOrFail($id);
        return view('clients.modifier', compact('client'));
    }

    public function supprimer($id)
    {
        $client = Client::findOrFail($id);
        $client->delete();

        return redirect()->route('clients.index')->with('succes', 'Client supprimé avec succès.');
    }

    public function mettreAJour(Request $requete, $id)
    {
        $requete->validate([
            'nom' => 'required|string',
            'email' => 'required|email',
            'adresse' => 'required|string',
            'code_postal' => 'required|string',
            'ville' => 'required|string',
            'note' => 'nullable|string',
            'telephone' => 'required|string',
        ]);

        $client = Client::findOrFail($id);

        $client->update([
            'nom' => $requete->nom,
            'email_client' => $requete->email,
            'adresse_client' => $requete->adresse,
            'cp_client' => $requete->code_postal,
            'ville_client' => $requete->ville,
            'commentaire_client' => $requete->note,
            'telephone_client' => $requete->telephone,
        ]);

        return redirect()->route('clients.index')->with('succes', 'Client modifié avec succès.');
    }

    public function supprimes()
    {
        $clients = Client::onlyTrashed()->get(); // récupère uniquement les clients supprimés
        return view('clients.supprimes', compact('clients'));
    }

    public function restaurer($id)
{
    $client = Client::onlyTrashed()->findOrFail($id);
    $client->restore();

    return redirect()->route('clients.supprimes')->with('succes', 'Client restauré avec succès.');
}


public function supprimerDefinitivement($id)
{
    $client = Client::onlyTrashed()->findOrFail($id);
    $client->forceDelete();

    return redirect()->route('clients.supprimes')->with('succes', 'Client supprimé définitivement.');
}

public function supprimerToutDefinitivement()
{
    Client::onlyTrashed()->forceDelete(); // ⚠️ à adapter pour Rdv ou Facture
    return redirect()->route('clients.supprimes')->with('succes', 'Tous les clients supprimés ont été supprimés définitivement.');
}


    
}
