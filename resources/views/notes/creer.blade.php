@extends('layouts.app')

@section('content')
    <h1 style="text-align: center;">Ajouter une note</h1>

    @if ($errors->any())
        <div style="color: red; text-align:center;">
            <ul>
                @foreach ($errors->all() as $erreur)
                    <li>{{ $erreur }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('notes.enregistrer') }}" style="max-width: 500px; margin: 30px auto;">
        @csrf

        <label for="client_id"><strong>Client :</strong></label>
        <select name="client_id" id="client_id" required style="width: 100%; padding: 10px; margin-bottom: 20px;">
            <option value="">-- Choisir un client --</option>
            @foreach ($clients as $client)
                <option value="{{ $client->id }}">{{ $client->nom }}</option>
            @endforeach
        </select>

        <div style="margin-bottom: 20px;">
    <label for="couleur" style="font-weight: bold;">Couleur du post-it :</label>
    <select name="couleur" id="couleur" style="width: 100%; padding: 8px;" required>
        <option value="#ffff88" {{ (old('couleur', $note->couleur ?? '') == '#ffff88') ? 'selected' : '' }}>🟨 Jaune</option>
        <option value="#ffc0cb" {{ (old('couleur', $note->couleur ?? '') == '#ffc0cb') ? 'selected' : '' }}>🌸 Rose</option>
        <option value="#d0f0c0" {{ (old('couleur', $note->couleur ?? '') == '#d0f0c0') ? 'selected' : '' }}>💚 Vert clair</option>
        <option value="#add8e6" {{ (old('couleur', $note->couleur ?? '') == '#add8e6') ? 'selected' : '' }}>💙 Bleu clair</option>
        <option value="#fffacd" {{ (old('couleur', $note->couleur ?? '') == '#fffacd') ? 'selected' : '' }}>🌕 Crème</option>
    </select>
</div>



        <label for="contenu"><strong>Contenu de la note :</strong></label>
        <textarea name="contenu" id="contenu" rows="4" required style="width: 100%; padding: 10px;"></textarea>

        <div style="text-align: center; margin-top: 20px;">
            <button type="submit"
                    style="padding: 10px 15px; background-color: #28a745; color: white; border: none; border-radius: 5px; font-weight: bold; cursor: pointer;">
                ✅ Enregistrer la note
            </button>
        </div>
        
    </form>

    <div style="text-align: center;">
        <a href="{{ route('notes.index') }}" style="text-decoration: none;">⬅️ Retour à la liste des notes</a>
    </div>
@endsection
