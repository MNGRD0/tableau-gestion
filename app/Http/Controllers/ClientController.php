<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Client;
use App\Models\Facture;
use App\Models\Rdv;
// On importe les modèles Client, Facture et Rdv pour interagir avec la base de données.
use Illuminate\Support\Facades\Hash;
// On importe "Hash" pour les opérations de chiffrement (ex : mot de passe).

class ClientController extends Controller
// Contrôleur principal qui gère toute la logique des clients.
{
    // Affiche la liste des clients avec tri et pagination (côté admin) :
    public function index(Request $request)
    {
        $tri = $request->get('tri');       // tri demandé (a_z, z_a, recent, ancien)
        $mode = $request->get('mode');     // "tout" ou limité à 10

        $clients = Client::query();        // on commence une requête sur le modèle Client

        // Applique le tri selon ce que l’admin a choisi
        if ($tri === 'a_z') {
            $clients->orderBy('nom', 'asc'); // "asc" = ascendant (de A à Z)
        } elseif ($tri === 'z_a') {
            $clients->orderBy('nom', 'desc'); // "desc" = descendant (de Z à A)
        } elseif ($tri === 'recent') {
            $clients->orderBy('created_at', 'desc'); // les plus récents en haut
        } elseif ($tri === 'ancien') {
            $clients->orderBy('created_at', 'asc'); // les plus anciens en haut
        }

        // Si on veut tous les clients → on utilise get()
        // Sinon, on limite à 10 clients max
        $clients = $mode === 'tout' ? $clients->get() : $clients->limit(10)->get();

        return view('clients.index', compact('clients', 'tri', 'mode'));
        // On affiche la vue avec les clients et les options de tri qui étaient sélectionnées.
    }

    // Affiche le formulaire pour ajouter un nouveau client
    public function creer()
    {
        return view('clients.creer');
    }

    // Enregistre un nouveau client (création par l’admin)
    public function enregistrer(Request $requete)
    {
        // 🔒 Vérifie que les champs sont bien remplis
        $requete->validate([
            'nom' => 'required|string',
            'email' => 'required|email',
            'adresse' => 'required|string',
            'code_postal' => 'required|string',
            'ville' => 'required|string',
            'note' => 'nullable|string',
            'telephone' => 'required|string',
        ]);
        // "required" = champ obligatoire
        // "nullable" = champ facultatif
        // "email" = format email valide
        // "string" = doit être du texte

        // Crée un nouveau client dans la base
        Client::create([
            'nom' => $requete->nom,
            'email_client' => $requete->email,
            'adresse_client' => $requete->adresse,
            'cp_client' => $requete->code_postal,
            'ville_client' => $requete->ville,
            'commentaire_client' => $requete->note,
            'telephone_client' => $requete->telephone,
        ]);

        // Redirige vers la liste avec un message de succès
        return redirect()->route('clients.index')->with('succes', 'Client ajouté avec succès.');
    }

    // Affiche les détails d’un client (vue pour l’admin)
    public function afficher($id)
    {
        $client = Client::findOrFail($id); // récupère le client ou affiche une erreur si introuvable
        return view('clients.afficher', compact('client'));
    }

    // Affiche le formulaire de modification pour un client
    public function modifier($id)
    {
        $client = Client::findOrFail($id);
        return view('clients.modifier', compact('client'));
    }

    // Supprime un client (suppression logique, il reste en base mais marqué comme supprimé)
    public function supprimer($id)
    {
        $client = Client::findOrFail($id);
        $client->delete(); // "delete()" = supprime logiquement le client (soft delete)

        return redirect()->route('clients.index')->with('succes', 'Client supprimé avec succès.');
    }

    // Met à jour les infos d’un client
    public function mettreAJour(Request $requete, $id)
    {
        // 🔒 Vérifie les données envoyées
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

        // Met à jour les données dans la base
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

    // Liste les clients supprimés (affiche la corbeille)
    public function supprimes()
    {
        $clients = Client::onlyTrashed()->get(); // récupère uniquement les clients supprimés (soft delete)
        return view('clients.supprimes', compact('clients'));
    }

    // Restaure un client supprimé
    public function restaurer($id)
    {
        $client = Client::onlyTrashed()->findOrFail($id);
        $client->restore(); // "restore()" = remet l’élément actif (annule le soft delete)

        return redirect()->route('clients.supprimes')->with('succes', 'Client restauré avec succès.');
    }

    // Supprime définitivement un seul client
    public function supprimerDefinitivement($id)
    {
        $client = Client::onlyTrashed()->findOrFail($id);
        $client->forceDelete(); // "forceDelete()" = supprime définitivement de la base

        return redirect()->route('clients.supprimes')->with('succes', 'Client supprimé définitivement.');
    }

    // Supprime définitivement tous les clients supprimés
    public function supprimerToutDefinitivement()
    {
        Client::onlyTrashed()->forceDelete();
        return redirect()->route('clients.supprimes')->with('succes', 'Tous les clients supprimés ont été supprimés définitivement.');
    }

    // Afficher l’espace personnel du client connecté :
    public function espace()
    {
        $clientId = session('client_id'); // récupère l’ID du client connecté
        if (!$clientId) {
            return redirect()->route('client.connexion')->withErrors(['connexion' => 'Vous devez être connecté.']);
        }

        $client = Client::findOrFail($clientId); // récupère le client
        $factures = Facture::where('client_id', $client->id)->get(); // récupère ses factures
        $rdvs = Rdv::where('client_id', $client->id)->get();         // récupère ses rendez-vous

        return view('clients.mon-espace', compact('client', 'factures', 'rdvs'));
    }

    // Afficher le formulaire pour modifier le profil du client connecté :
    public function modifierProfil()
    {
        $client = Client::findOrFail(session('client_id'));
        return view('clients.modifier-profil', compact('client'));
    }

    // Met à jour les infos du profil client connecté
    public function mettreAJourProfil(Request $request)
    {
        $client = Client::findOrFail(session('client_id'));

        $request->validate([
            'nom' => 'required|string',
            'telephone_client' => 'required|string',
            'email_client' => 'required|email|unique:client,email_client,' . $client->id,
            // "unique:client,email_client,ID" = l'email doit être unique sauf pour ce client précis
            'adresse_client' => 'required|string',
            'cp_client' => 'required|string',
            'ville_client' => 'required|string',
            'mot_de_passe_client' => 'nullable|string|min:6|confirmed'
            // "nullable" = pas obligatoire
            // "confirmed" = Laravel va comparer avec un champ "mot_de_passe_client_confirmation"
        ]);

        $donnees = [
            'nom' => $request->nom,
            'telephone_client' => $request->telephone_client,
            'email_client' => $request->email_client,
            'adresse_client' => $request->adresse_client,
            'cp_client' => $request->cp_client,
            'ville_client' => $request->ville_client,
        ];

        if ($request->filled('mot_de_passe_client')) {
            // Si un nouveau mot de passe a été renseigné, on le chiffre
            $donnees['mot_de_passe_client'] = Hash::make($request->mot_de_passe_client);
            // "Hash::make()" = chiffre le mot de passe avant de le stocker
        }

        $client->update($donnees); //Il va mettre à jour avec les nouvelles données $donnees

        return redirect()->route('client.espace')->with('success', 'Profil mis à jour avec succès.');
    }
}
