<?php

namespace App\Http\Controllers;
// "namespace" = espace de nommage pour organiser les fichiers. Ici, on est dans le dossier des contrôleurs Laravel.

use App\Models\Note;
// "use" = on importe le modèle Note (M de MVC) pour l'utiliser dans ce fichier
use App\Models\Client;
// On importe aussi le modèle Client car chaque note est liée à un client
use Illuminate\Http\Request;
// On importe la classe Request de Laravel, qui permet de récupérer les données envoyées par l'utilisateur (formulaire, URL, etc.)

class NoteController extends Controller
// "class" = mot-clé qui permet de définir une classe en PHP (ici, un contrôleur)
// "extends Controller" = ce contrôleur hérite des fonctionnalités de base fournies par Laravel
{
    public function index()
    // "public" = la fonction est accessible par Laravel (via une route)
    // "function" = permet de définir une fonction (bloc de code)
    // "index" = nom de la fonction, ici elle sert à afficher la liste des notes
    {
        $notes = Note::with('client')->orderBy('created_at', 'desc')->get();
        // "with('client')" = Laravel charge aussi le client lié à chaque note (relation dans le modèle Note)
        // "orderBy('created_at', 'desc')" = trie les notes par date de création décroissante (plus récentes en haut)
        // "get()" = exécute la requête et récupère les résultats depuis la base de données

        return view('notes.index', compact('notes'));
        // "view()" = Laravel charge une vue Blade
        // "compact('notes')" = crée un tableau ['notes' => $notes] pour l'envoyer à la vue
    }

    public function creer()
    // Affiche le formulaire pour créer une nouvelle note
    {
        $clients = Client::orderBy('nom')->get();
        // Récupère la liste des clients triés par nom (pour afficher dans le formulaire)

        return view('notes.creer', compact('clients'));
        // Charge la vue "notes/creer.blade.php" avec la liste des clients
    }

    public function enregistrer(Request $requete)
    // Fonction appelée quand on envoie le formulaire pour créer une note
    // "$requete" contient tout ce que l'utilisateur a rempli dans le formulaire
    {
        $requete->validate([
            'client_id' => 'required|exists:client,id',
            // "required" = champ obligatoire
            // "exists:client,id" = l'ID doit exister dans la table client, colonne id

            'contenu' => 'required|string',
            // "string" = doit être du texte

            'couleur' => 'required|string',
        ]);
        // "validate()" = Laravel vérifie les règles ; s'il y a une erreur, il redirige avec un message

        Note::create([
            'client_id' => $requete->client_id,
            'contenu' => $requete->contenu,
            'couleur' => $requete->couleur,
        ]);
        // "create()" = ajoute une nouvelle ligne dans la table "notes" avec les données fournies

        return redirect()->route('notes.index')->with('succes', 'Note ajoutée avec succès.');
        // "redirect()" = redirige vers une autre page
        // "route('notes.index')" = vers la route nommée "notes.index" (page liste des notes)
        // "with()" = envoie un message temporaire (flash) à la prochaine page
    }

    public function afficher($id)
    // Affiche les détails d'une note en fonction de son ID
    {
        $note = Note::with('client')->findOrFail($id);
        // "findOrFail()" = cherche la note avec l'ID donné
        // si trouvée → retourne la note ; sinon → Laravel affiche une erreur 404 automatiquement

        return view('notes.afficher', compact('note'));
        // Charge la vue "notes/afficher.blade.php" avec la variable $note
    }

    public function modifier($id)
    // Affiche le formulaire de modification d'une note
    {
        $note = Note::findOrFail($id);
        // Récupère la note à modifier (ou erreur 404 si elle n'existe pas)

        $clients = Client::orderBy('nom')->get();
        // Liste des clients à proposer dans le formulaire

        return view('notes.modifier', compact('note', 'clients'));
        // Envoie la note et les clients à la vue "notes/modifier.blade.php"
    }

    public function mettreAJour(Request $requete, $id)
    // Met à jour une note existante
    {
        $requete->validate([
            'client_id' => 'required|exists:client,id',
            'contenu' => 'required|string',
            'couleur' => 'required|string',
        ]);
        // Validation des nouvelles données saisies par l'utilisateur

        $note = Note::findOrFail($id);
        // Récupère la note à modifier (sinon erreur 404)

        $note->update([
            // "update()" = met à jour les colonnes de la note avec les nouvelles valeurs
            'client_id' => $requete->client_id,
            'contenu' => $requete->contenu,
            'couleur' => $requete->couleur,
        ]);

        return redirect()->route('notes.index')->with('succes', 'Note modifiée avec succès.');
        // Redirige avec un message de confirmation
    }

    public function supprimer($id)
    // Supprime une note logiquement (soft delete)
    {
        $note = Note::findOrFail($id);
        $note->delete();
        // "delete()" = ne supprime pas vraiment → remplit la colonne "deleted_at"

        return redirect()->route('notes.index')->with('succes', 'Note supprimée.');
    }

    public function supprimes()
    // Affiche la liste des notes supprimées (corbeille)
    {
        $notes = Note::onlyTrashed()->with('client')->get();
        // "onlyTrashed()" = récupère uniquement les notes supprimées (soft delete)

        return view('notes.supprimes', compact('notes'));
        // Affiche la vue "notes/supprimes.blade.php" avec les notes supprimées
    }

    public function restaurer($id)
    // Restaure une note supprimée (remet deleted_at à null)
    {
        $note = Note::onlyTrashed()->findOrFail($id);
        $note->restore();
        // "restore()" = annule la suppression logique

        return redirect()->route('notes.supprimes')->with('succes', 'Note restaurée avec succès.');
    }

    public function supprimerDefinitivement($id)
    // Supprime une note de façon permanente de la base
    {
        $note = Note::onlyTrashed()->findOrFail($id);
        $note->forceDelete();
        // "forceDelete()" = supprime complètement la ligne de la base (pas récupérable)

        return redirect()->route('notes.supprimes')->with('succes', 'Note supprimée définitivement.');
    }

    public function supprimerToutesDefinitivement()
    // Supprime définitivement toutes les notes de la corbeille
    {
        Note::onlyTrashed()->forceDelete();
        // Supprime toutes les notes ayant été soft deleted (deleted_at non nul)

        return redirect()->route('notes.supprimes')->with('succes', 'Toutes les notes supprimées ont été définitivement supprimées.');
    }
}
