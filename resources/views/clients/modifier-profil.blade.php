<!-- resources/views/client/modifier-profil.blade.php -->

@extends('layouts.app') 
<!-- On utilise le layout principal de Laravel (layouts/app.blade.php) -->

@section('content')
<main> <!-- ✅ Ajout recommandé pour l’accessibilité -->
<div class="container" style="max-width: 600px; margin: auto; padding-top: 30px;">

    <!-- Titre principal de la page -->
    <h2 style="text-align: center; margin-bottom: 20px;">Modifier mes informations</h2>

    <!-- Si des erreurs de validation sont présentes, on les affiche ici sous forme de liste -->
    @if ($errors->any())
        <div style="color: red; margin-bottom: 20px;">
            <ul>
                @foreach ($errors->all() as $erreur)
                    <li>{{ $erreur }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <!-- Message flash de succès si les infos ont été modifiées -->
    @if (session('success'))
        <div style="color: green; margin-bottom: 20px;">
            {{ session('success') }}
        </div>
    @endif

    <!-- Formulaire d'envoi des nouvelles infos -->
    <form method="POST" action="{{ route('client.profil.mettreAJour') }}">
        @csrf <!-- Protection CSRF obligatoire -->

        <!-- Champ NOM -->
        <label for="nom">Nom :</label>
        <input type="text" name="nom" id="nom" 
               value="{{ old('nom', $client->nom) }}" required 
               style="width: 100%; margin-bottom: 15px;">
        <!-- old() = garde la valeur précédente en cas d'erreur -->

        <!-- Téléphone -->
        <label for="telephone_client">Téléphone :</label>
        <input type="text" name="telephone_client" id="telephone_client"
               value="{{ old('telephone_client', $client->telephone_client) }}" required 
               style="width: 100%; margin-bottom: 15px;">

        <!-- Email -->
        <label for="email_client">Email :</label>
        <input type="email" name="email_client" id="email_client" 
               value="{{ old('email_client', $client->email_client) }}" required 
               style="width: 100%; margin-bottom: 15px;">

        <!-- Adresse -->
        <label for="adresse_client">Adresse :</label>
        <input type="text" name="adresse_client" id="adresse_client" 
               value="{{ old('adresse_client', $client->adresse_client) }}" required 
               style="width: 100%; margin-bottom: 15px;">

        <!-- Code postal -->
        <label for="cp_client">Code postal :</label>
        <input type="text" name="cp_client" id="cp_client" 
               value="{{ old('cp_client', $client->cp_client) }}" required 
               style="width: 100%; margin-bottom: 15px;">

        <!-- Ville -->
        <label for="ville_client">Ville :</label>
        <input type="text" name="ville_client" id="ville_client" 
               value="{{ old('ville_client', $client->ville_client) }}" required 
               style="width: 100%; margin-bottom: 15px;">

        <!-- Nouveau mot de passe (optionnel) -->
        <label for="mot_de_passe_client">Nouveau mot de passe (laisser vide pour ne pas changer) :</label>
        <input type="password" name="mot_de_passe_client" id="mot_de_passe_client" 
               style="width: 100%; margin-bottom: 15px;">

        <!-- Confirmation mot de passe -->
        <label for="mot_de_passe_client_confirmation">Confirmer le nouveau mot de passe :</label>
        <input type="password" name="mot_de_passe_client_confirmation" id="mot_de_passe_client_confirmation" 
               style="width: 100%; margin-bottom: 20px;">

        <!-- Bouton envoyer -->
        <div style="text-align: center;">
            <button type="submit" 
                    style="padding: 10px 20px; background-color: #38c172; color: white; border: none; border-radius: 5px; cursor: pointer;">
                Enregistrer les modifications
            </button>
        </div>
    </form>
</div>
</main>
@endsection
