@extends('layouts.app')

@section('content')
    <h1 style="text-align: center;">Modifier le client</h1>

    <form action="{{ route('clients.mettreAJour', $client->id) }}" method="POST" style="max-width: 600px; margin: 0 auto;">
        @csrf
        @method('PUT')

        <div style="margin-bottom: 15px;">
            <label for="nom">Nom :</label><br>
            <input type="text" name="nom" id="nom" value="{{ $client->nom }}" required style="width: 100%;">
        </div>

        <div style="margin-bottom: 15px;">
            <label for="telephone">Téléphone :</label><br>
            <input type="text" name="telephone" id="telephone" value="{{ $client->telephone_client }}" required style="width: 100%;">
        </div>

        <div style="margin-bottom: 15px;">
            <label for="email">Email :</label><br>
            <input type="email" name="email" id="email" value="{{ $client->email_client }}" required style="width: 100%;">
        </div>

        <div style="margin-bottom: 15px;">
            <label for="adresse">Adresse :</label><br>
            <input type="text" name="adresse" id="adresse" value="{{ $client->adresse_client }}" required style="width: 100%;">
        </div>

        <div style="margin-bottom: 15px;">
            <label for="code_postal">Code postal :</label><br>
            <input type="text" name="code_postal" id="code_postal" value="{{ $client->cp_client }}" required style="width: 100%;">
        </div>

        <div style="margin-bottom: 15px;">
            <label for="ville">Ville :</label><br>
            <input type="text" name="ville" id="ville" value="{{ $client->ville_client }}" required style="width: 100%;">
        </div>

        <div style="margin-bottom: 15px;">
            <label for="note">Note :</label><br>
            <textarea name="note" id="note" rows="3" style="width: 100%;">{{ $client->commentaire_client }}</textarea>
        </div>

        <div style="text-align: center;">
        <button type="submit" style="padding: 10px 20px; background-color: orange; color: white; border: none; border-radius: 5px; cursor: pointer;">
            Enregistrer les modifications
        </button>
        </div>
    </form>
@endsection
