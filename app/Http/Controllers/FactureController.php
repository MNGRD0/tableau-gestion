<?php

namespace App\Http\Controllers;

use App\Models\Facture;
use App\Models\Client;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class FactureController extends Controller
{
    public function index(Request $requete)
    // Fonction exécutée quand on visite /factures (appelée par la route)
    // Elle récupère la liste des factures, possiblement filtrée et limitée
    {
        $filtre = $requete->get('filtre');
        // Récupère la valeur dans l'URL ?filtre=... (ex : ?filtre=payée)

        $mode = $requete->get('mode');
        // Récupère le mode d'affichage : "tout" ou affichage limité

        $factures = Facture::with('client');
        // Crée une requête sur le modèle Facture
        // "with('client')" = Laravel va aussi charger automatiquement le client associé à chaque facture (relation dans le modèle)

        if ($filtre) {
            $factures->where('statut_facture', $filtre);
            // Si un filtre est appliqué, on ajoute une condition SQL (WHERE statut_facture = ...)
        }

        $factures->orderBy('created_at', 'desc');
        // Trie les factures par date de création, les plus récentes en premier (ORDER BY created_at DESC)

        if ($mode !== 'tout') {
            $factures = $factures->limit(10);
            // Si l'utilisateur n'a pas demandé "tout", on limite la requête à 10 factures
        }

        $factures = $factures->get();
        // Exécute la requête SQL et récupère les résultats (array de factures avec leurs clients)

        return view('factures.index', compact('factures', 'filtre', 'mode'));
        // Laravel va afficher la vue Blade "factures/index.blade.php"
        // avec les variables $factures, $filtre et $mode utilisables dans la vue
    }

    public function creer()
    // Affiche le formulaire de création d'une nouvelle facture
    {
        $clients = Client::orderBy('nom')->get();
        // Récupère tous les clients triés par nom, pour remplir la liste déroulante

        return view('factures.creer', compact('clients'));
        // Affiche la vue Blade "factures/creer.blade.php" avec la liste des clients disponible
    }

    public function enregistrer(Request $requete)
    // Enregistre une nouvelle facture envoyée par le formulaire
    {
        $requete->validate([
            'client_id' => 'required|exists:client,id',
            'montant' => 'required|numeric',
            'moyen_paiement' => 'required',
            'statut_facture' => 'required|in:payée,non payée',
            'commentaire_facture' => 'nullable|string',
        ]);
        // Laravel vérifie que tous les champs sont valides (format, présence...)
        // Sinon il redirige avec les erreurs

        $client = Client::findOrFail($requete->client_id);
        // Récupère le client associé à l'ID envoyé
        // Si aucun client ne correspond, Laravel affiche une erreur 404

        Facture::create([
            'client_id' => $client->id,
            'nom_client' => $client->nom,
            'montant' => $requete->montant,
            'moyen_paiement' => $requete->moyen_paiement,
            'echelonner' => $requete->has('echelonner'),
            // has() vérifie si la case échelonner est cochée (true/false)
            'statut_facture' => $requete->statut_facture,
            'commentaire_facture' => $requete->commentaire_facture,
        ]);
        // Crée une nouvelle facture en base avec les données fournies

        return redirect()->route('factures.index')->with('succes', 'Facture ajoutée avec succès.');
        // Redirige vers la liste des factures avec un message flash temporaire
    }

    public function afficher($id)
    // Affiche les détails d'une facture via son ID
    {
        $facture = Facture::with('client')->findOrFail($id);
        // Récupère la facture et son client associé
        // Si la facture n'existe pas, Laravel affiche une erreur 404

        return view('factures.afficher', compact('facture'));
        // Affiche la vue Blade "factures/afficher.blade.php" avec la variable $facture
    }

    public function modifier($id)
    // Affiche le formulaire de modification d'une facture existante
    {
        $facture = Facture::findOrFail($id);
        $clients = Client::orderBy('nom')->get();
        return view('factures.modifier', compact('facture', 'clients'));
    }

    public function mettreAJour(Request $requete, $id)
    // Met à jour une facture existante avec les nouvelles données envoyées
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
        // Met à jour la facture en base avec les nouvelles valeurs reçues

        return redirect()->route('factures.index')->with('succes', 'Facture modifiée avec succès.');
    }

    public function supprimer($id)
    // Supprime une facture logiquement (soft delete)
    {
        $facture = Facture::findOrFail($id);
        $facture->delete();
        // Soft delete = Laravel remplit la colonne deleted_at au lieu de supprimer vraiment la ligne
        return redirect()->route('factures.index')->with('succes', 'Facture supprimée avec succès.');
    }

    public function genererPDF($id)
    // Génère un fichier PDF à partir de la vue Blade de la facture
    {
        $facture = Facture::with('client')->findOrFail($id);
        // On récupère la facture + client associé pour remplir la vue

        $pdf = Pdf::loadView('factures.pdf', compact('facture'));
        // 1. Laravel va chercher le fichier Blade : resources/views/factures/pdf.blade.php
        // 2. Il remplit ce fichier avec les données ($facture)
        // 3. DomPDF transforme le HTML généré en un fichier PDF prêt à être téléchargé

        return $pdf->download('facture_' . $facture->id . '.pdf');
        // Envoie le PDF à l'utilisateur avec un nom personnalisé (Content-Disposition: attachment)
    }

    public function supprimees()
    // Affiche la liste des factures supprimées logiquement
    {
        $factures = Facture::onlyTrashed()->with('client')->get();
        return view('factures.supprimees', compact('factures'));
    }

    public function restaurer($id)
    // Restaure une facture supprimée (annule le soft delete)
    {
        $facture = Facture::onlyTrashed()->findOrFail($id);
        $facture->restore();
        return redirect()->route('factures.supprimees')->with('succes', 'Facture restaurée avec succès.');
    }

    public function supprimerDefinitivement($id)
    // Supprime définitivement une facture (vraie suppression de la base)
    {
        $facture = Facture::onlyTrashed()->findOrFail($id);
        $facture->forceDelete();
        return redirect()->route('factures.supprimees')->with('succes', 'Facture supprimée définitivement.');
    }

    public function supprimerToutDefinitivement()
    // Supprime toutes les factures supprimées logiquement
    {
        Facture::onlyTrashed()->forceDelete();
        return redirect()->route('factures.supprimes')->with('succes', 'Toutes les factures supprimées ont été supprimées définitivement.');
    }

    public function telechargerPDFClient($id)
    // Permet au client connecté de télécharger sa propre facture
    {
        $clientId = session('client_id');
        // Récupère l'ID du client stocké dans la session (connexion client)

        if (!$clientId) {
            return redirect()->route('client.connexion')->withErrors(['connexion' => 'Veuillez vous connecter.']);
            // Si le client n'est pas connecté, on le renvoie vers la page de connexion avec un message
        }

        $facture = Facture::where('id', $id)
            ->where('client_id', $clientId)
            ->firstOrFail();
        // Vérifie que la facture appartient bien à ce client (sécurité)
        // Si la facture n'existe pas ou n'appartient pas à ce client, erreur 404

        $pdf = Pdf::loadView('factures.pdf', compact('facture'));
        // Même principe que plus haut : on génère un PDF depuis la vue Blade remplie

        return $pdf->download('facture_' . $facture->numero . '.pdf');
        // Téléchargement du PDF avec un nom personnalisé contenant le numéro de facture
    }
}
