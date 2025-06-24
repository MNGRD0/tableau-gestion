<?php

namespace App\Http\Controllers;

use App\Models\Note;
use App\Models\Client;
use Illuminate\Http\Request;

class NoteController extends Controller
{
    public function index()
    {
        $notes = Note::with('client')->orderBy('created_at', 'desc')->get();
        return view('notes.index', compact('notes'));
    }

    public function creer()
    {
        $clients = Client::orderBy('nom')->get();
        return view('notes.creer', compact('clients'));
    }

    public function enregistrer(Request $requete)
    {
        $requete->validate([
            'client_id' => 'required|exists:client,id',
            'contenu' => 'required|string',
            'couleur' => 'required|string',
        ]);
        

        Note::create([
            'client_id' => $requete->client_id,
            'contenu' => $requete->contenu,
            'couleur' => $requete->couleur,
        ]);

        return redirect()->route('notes.index')->with('succes', 'Note ajoutée avec succès.');
    }

    public function afficher($id)
    {
        $note = Note::with('client')->findOrFail($id);
        return view('notes.afficher', compact('note'));
    }

    public function modifier($id)
    {
        $note = Note::findOrFail($id);
        $clients = Client::orderBy('nom')->get();
        return view('notes.modifier', compact('note', 'clients'));
    }

    public function mettreAJour(Request $requete, $id)
    {
        $requete->validate([
            'client_id' => 'required|exists:client,id',
            'contenu' => 'required|string',
            'couleur' => 'required|string',
        ]);

        $note = Note::findOrFail($id);

        $note->update([
            'client_id' => $requete->client_id,
            'contenu' => $requete->contenu,
            'couleur' => $requete->couleur,
        ]);

        return redirect()->route('notes.index')->with('succes', 'Note modifiée avec succès.');
    }

    public function supprimer($id)
    {
        $note = Note::findOrFail($id);
        $note->delete();

        return redirect()->route('notes.index')->with('succes', 'Note supprimée.');
    }

    public function supprimes()
    {
        $notes = Note::onlyTrashed()->with('client')->get();
        return view('notes.supprimes', compact('notes'));
    }

    public function restaurer($id)
    {
        $note = Note::onlyTrashed()->findOrFail($id);
        $note->restore();

        return redirect()->route('notes.supprimes')->with('succes', 'Note restaurée avec succès.');
    }

    public function supprimerDefinitivement($id)
    {
        $note = Note::onlyTrashed()->findOrFail($id);
        $note->forceDelete();

        return redirect()->route('notes.supprimes')->with('succes', 'Note supprimée définitivement.');
    }

    public function supprimerToutesDefinitivement()
{
    Note::onlyTrashed()->forceDelete();

    return redirect()->route('notes.supprimes')->with('succes', 'Toutes les notes supprimées ont été définitivement supprimées.');
}

}
