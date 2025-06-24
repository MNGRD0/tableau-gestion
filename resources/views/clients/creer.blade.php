@extends('layouts.app')

@section('content')
    <h1 style="text-align: center;">Ajouter un client</h1>

    <form action="{{ route('clients.enregistrer') }}" method="POST" style="max-width: 600px; margin: 0 auto;">
        @csrf

        <div style="margin-bottom: 15px;">
            <label for="nom">Nom :</label><br>
            <input type="text" name="nom" id="nom" required style="width: 100%;">
        </div>

        <div style="margin-bottom: 15px;">
            <label for="telephone">Téléphone :</label><br>
            <input type="text" name="telephone" id="telephone" required style="width: 100%;">
        </div>

        <div style="margin-bottom: 15px;">
            <label for="email">Email :</label><br>
            <input type="email" name="email" id="email" required style="width: 100%;">
        </div>

        <div style="margin-bottom: 15px;">
            <label for="adresse">Adresse :</label><br>
            <input type="text" name="adresse" id="adresse" required style="width: 100%;">
        </div>

        <div style="margin-bottom: 15px;">
            <label for="code_postal">Code postal :</label><br>
            <input type="text" name="code_postal" id="code_postal" required style="width: 100%;">
        </div>

        <div style="margin-bottom: 15px;">
            <label for="ville">Ville :</label><br>
            <input type="text" name="ville" id="ville" required style="width: 100%;">
        </div>

        <div style="margin-bottom: 15px;">
            <label for="note">Note :</label><br>
            <textarea name="note" id="note" rows="3" style="width: 100%;"></textarea>
        </div>

        
    <div style="text-align: center;">
        <button type="submit" style="padding: 10px 20px; background-color: green; color: white; border: none; border-radius: 5px; cursor: pointer;">
            Enregistrer
        </button>
        </div>
    </form>
@endsection
