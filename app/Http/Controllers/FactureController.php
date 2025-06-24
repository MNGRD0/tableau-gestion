<?php

namespace App\Http\Controllers;

use App\Models\Facture;
use App\Models\Client;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class FactureController extends Controller
{
    public function index(Request $requete)
    {
        $filtre = $requete->get('filtre');
        $mode = $requete->get('mode'); // nouveau : pour afficher toutes les factures ou non

        $factures = Facture::with('client');

        if ($filtre) {
            $factures->where('statut_facture', $filtre);
        }

        $factures->orderBy('created_at', 'desc');

        // S'il y a plus de 10 factures et qu'on n'a pas demandé "tout", on limite à 10
        if ($mode !== 'tout') {
            $factures = $factures->limit(10);
        }

        $factures = $factures->get();

        return view('factures.index', compact('factures', 'filtre', 'mode'));
    }

    public function creer()
    {
        $clients = Client::orderBy('nom')->get();
        return view('factures.creer', compact('clients'));
    }

    public function enregistrer(Request $requete)
    {
        $requete->validate([
            'client_id' => 'required|exists:client,id',
            'montant' => 'required|numeric',
            'moyen_paiement' => 'required',
            'statut_facture' => 'required|in:payée,non payée',
            'commentaire_facture' => 'nullable|string',
        ]);

        $client = Client::findOrFail($requete->client_id);

        Facture::create([
            'client_id' => $client->id,
            'nom_client' => $client->nom,
            'montant' => $requete->montant,
            'moyen_paiement' => $requete->moyen_paiement,
            'echelonner' => $requete->has('echelonner'),
            'statut_facture' => $requete->statut_facture,
            'commentaire_facture' => $requete->commentaire_facture,
        ]);

        return redirect()->route('factures.index')->with('succes', 'Facture ajoutée avec succès.');
    }

    // Afficher une facture
public function afficher($id)
{
    $facture = Facture::with('client')->findOrFail($id);
    return view('factures.afficher', compact('facture'));
}

// Modifier une facture
public function modifier($id)
{
    $facture = Facture::findOrFail($id);
    $clients = Client::orderBy('nom')->get();
    return view('factures.modifier', compact('facture', 'clients'));
}

// Mettre à jour une facture
public function mettreAJour(Request $requete, $id)
{
    $requete->validate([
        'client_id' => 'required|exists:client,id',
        'montant' => 'required|numeric',
        'moyen_paiement' => 'required',
        'statut_facture' => 'required|in:payée,non payée',
        'commentaire_facture' => 'nullable|string',
    ]);

    $facture = Facture::findOrFail($id);
    $client = Client::findOrFail($requete->client_id);

    $facture->update([
        'client_id' => $client->id,
        'nom_client' => $client->nom,
        'montant' => $requete->montant,
        'moyen_paiement' => $requete->moyen_paiement,
        'echelonner' => $requete->has('echelonner'),
        'statut_facture' => $requete->statut_facture,
        'commentaire_facture' => $requete->commentaire_facture,
    ]);

    return redirect()->route('factures.index')->with('succes', 'Facture modifiée avec succès.');
}

// Supprimer une facture
public function supprimer($id)
{
    $facture = Facture::findOrFail($id);
    $facture->delete();

    return redirect()->route('factures.index')->with('succes', 'Facture supprimée avec succès.');
}


public function genererPDF($id)
{
    $facture = Facture::with('client')->findOrFail($id);

    // On passe les infos à une vue spéciale PDF
    $pdf = Pdf::loadView('factures.pdf', compact('facture'));

    return $pdf->download('facture_'.$facture->id.'.pdf');
}
public function supprimees()
{
    $factures = Facture::onlyTrashed()->with('client')->get();
    return view('factures.supprimees', compact('factures'));
}

public function restaurer($id)
{
    $facture = Facture::onlyTrashed()->findOrFail($id);
    $facture->restore();

    return redirect()->route('factures.supprimees')->with('succes', 'Facture restaurée avec succès.');
}

public function supprimerDefinitivement($id)
{
    $facture = Facture::onlyTrashed()->findOrFail($id);
    $facture->forceDelete();

    return redirect()->route('factures.supprimees')->with('succes', 'Facture supprimée définitivement.');
}

public function supprimerToutDefinitivement()
{
    Facture::onlyTrashed()->forceDelete(); // ⚠️ à adapter pour Rdv ou Facture
    return redirect()->route('factures.supprimes')->with('succes', 'Toutes les factures supprimées ont été supprimées définitivement.');
}


}
