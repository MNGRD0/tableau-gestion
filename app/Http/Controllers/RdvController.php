<?php

namespace App\Http\Controllers;
// "namespace" = espace de nommage : indique dans quel dossier logique on se trouve

use App\Models\Rdv;
// "use" = on importe le modèle Rdv pour l'utiliser ici (modèle = table rdvs)
use App\Models\Client;
// On importe le modèle Client pour pouvoir lier un rendez-vous à un client
use Illuminate\Http\Request;
// On importe la classe Request : elle contient les données envoyées par l'utilisateur (formulaire, URL...)

class RdvController extends Controller
// Ce contrôleur gère toutes les actions liées aux rendez-vous (affichage, création, suppression...)
{
    public function index(Request $requete)
    // "index" = méthode appelée pour afficher la liste des rendez-vous
    // "Request $requete" = Laravel injecte automatiquement les infos envoyées par l'utilisateur (GET/POST)
    {
        $filtre = $requete->get('filtre');
        // Récupère la valeur ?filtre=... dans l'URL (si présent)

        $rdvs = Rdv::with('client');
        // On prépare une requête sur le modèle Rdv et on demande aussi de charger le client associé 

        if ($filtre) {
            $rdvs->where('statut_rdv', $filtre);
            // Si un filtre est choisi, on ajoute une condition sur le champ "statut_rdv"
        }

        $rdvs = $rdvs->orderBy('date', 'asc')->get();
        // Trie les rendez-vous par date croissante, puis exécute la requête avec "get()"

        return view('rdv.index', compact('rdvs', 'filtre'));
        // Affiche la vue Blade "rdv/index.blade.php" avec les variables $rdvs et $filtre disponibles
    }

    public function creer()
    // Affiche le formulaire d'ajout d'un rendez-vous
    {
        $clients = Client::all();
        // Récupère tous les clients pour les afficher dans une liste déroulante

        return view('rdv.creer', compact('clients'));
        // Affiche la vue "rdv/creer.blade.php" avec les clients disponibles dans le formulaire
    }

    public function enregistrer(Request $requete)
    // Fonction exécutée lors de la soumission du formulaire d'ajout d'un rendez-vous
    {
        $requete->validate([
            'client_id' => 'required|exists:client,id',
            // "required" = champ obligatoire
            // "exists:client,id" = l'ID fourni doit exister dans la table client

            'date' => 'required|date',
            // Doit être une date valide

            'lieu' => 'required|string',
            'statut_rdv' => 'required|in:à venir,en cours,passé',
            // Le statut doit être l'une de ces valeurs

            'commentaire_rdv' => 'nullable|string',
            // Champ facultatif mais s'il est présent, il doit être une chaîne
        ]);
        // "validate()" = Laravel vérifie les données avant d'enregistrer

        $client = Client::findOrFail($requete->client_id);
        // On récupère le client lié à l'ID choisi
        // "findOrFail()" = si le client n'existe pas, Laravel affiche une erreur 404

        Rdv::create([
            'client_id' => $client->id,
            'nom_client' => $client->nom,
            // On remplit aussi le nom du client car il est stocké directement dans la table rdv
            'date' => $requete->date,
            'lieu' => $requete->lieu,
            'statut_rdv' => $requete->statut_rdv,
            'commentaire_rdv' => $requete->commentaire_rdv,
        ]);
        // "create()" = insère un nouveau rendez-vous dans la base de données

        return redirect()->route('rdv.index')->with('succes', 'Rendez-vous ajouté avec succès.');
        // Redirige vers la liste avec un message temporaire de succès
    }

    public function afficher($id)
    // Affiche les détails d'un rendez-vous
    {
        $rdv = Rdv::findOrFail($id);
        // Récupère le rendez-vous dont l'id est fourni. Sinon erreur 404.

        return view('rdv.afficher', compact('rdv'));
        // Affiche la vue "rdv/afficher.blade.php" avec la variable $rdv
    }

    public function modifier($id)
    // Affiche le formulaire de modification d'un rendez-vous
    {
        $rdv = Rdv::findOrFail($id);
        // Récupère le rendez-vous à modifier (ou erreur 404)

        $clients = Client::all();
        // Tous les clients à afficher dans une liste déroulante (si on souhaite changer de client)

        return view('rdv.modifier', compact('rdv', 'clients'));
        // Affiche la vue "rdv/modifier.blade.php"
    }

    public function supprimer($id)
    // Supprime logiquement un rendez-vous (soft delete)
    {
        $rdv = Rdv::findOrFail($id);
        $rdv->delete();
        // "delete()" = remplit le champ "deleted_at" au lieu de vraiment supprimer la ligne

        return redirect()->route('rdv.index')->with('succes', 'Rendez-vous supprimé avec succès.');
    }

    public function mettre_a_jour(Request $requete, $id)
    // Met à jour un rendez-vous existant
    {
        $requete->validate([
            'client_id' => 'required|exists:client,id',
            'date' => 'required|date',
            'lieu' => 'required|string',
            'statut_rdv' => 'required|in:à venir,en cours,passé',
            'commentaire_rdv' => 'nullable|string',
        ]);
        // Vérifie que les nouvelles données envoyées sont valides

        $rdv = Rdv::findOrFail($id);
        $client = Client::findOrFail($requete->client_id);

        $rdv->update([
            // "update()" = modifie la ligne correspondante dans la base de données
            'client_id' => $client->id,
            'nom_client' => $client->nom,
            'date' => $requete->date,
            'lieu' => $requete->lieu,
            'statut_rdv' => $requete->statut_rdv,
            'commentaire_rdv' => $requete->commentaire_rdv,
        ]);

        return redirect()->route('rdv.index')->with('succes', 'Rendez-vous modifié avec succès.');
    }

    public function supprimes()
    // Affiche la liste des rendez-vous supprimés (corbeille)
    {
        $rdvs = Rdv::onlyTrashed()->get();
        // "onlyTrashed()" = ne récupère que les lignes soft-deleted (deleted_at non nul)

        return view('rdv.supprimes', compact('rdvs'));
    }

    public function restaurer($id)
    // Restaure un rendez-vous supprimé
    {
        $rdv = Rdv::onlyTrashed()->findOrFail($id);
        // Récupère un rendez-vous supprimé

        $rdv->restore();
        // "restore()" = remet le champ deleted_at à null → réactive le rendez-vous

        return redirect()->route('rdv.supprimes')->with('succes', 'Rendez-vous restauré.');
    }

    public function supprimerDefinitivement($id)
    // Supprime définitivement un rendez-vous (non récupérable)
    {
        $rdv = Rdv::onlyTrashed()->findOrFail($id);
        $rdv->forceDelete();
        // "forceDelete()" = supprime la ligne de manière permanente dans la base

        return redirect()->route('rdv.supprimes')->with('succes', 'Rendez-vous supprimé définitivement.');
    }

    public function supprimerToutDefinitivement()
    // Supprime tous les rendez-vous supprimés logiquement
    {
        Rdv::onlyTrashed()->forceDelete();
        // Supprime toutes les lignes marquées comme supprimées (soft delete)

        return redirect()->route('rdv.supprimes')->with('succes', 'Tous les rendez-vous supprimés ont été supprimés définitivement.');
    }
}
