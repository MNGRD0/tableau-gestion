@extends('layouts.app')
<!-- On étend le layout principal du site (layouts/app.blade.php) -->

@section('content')
<!-- Début du contenu spécifique à cette vue -->

    <h1 style="text-align: center;">Modifier la note</h1>

    <!-- Affichage des erreurs de validation si des champs sont mal remplis -->
    @if ($errors->any())
        <div style="background-color: #f8d7da; color: #721c24; padding: 10px; border-radius: 5px; margin: 20px auto; width: 80%; text-align: center;">
            @foreach ($errors->all() as $error)
                <p>{{ $error }}</p> <!-- Affiche chaque message d’erreur -->
            @endforeach
        </div>
    @endif

    <!-- Formulaire pour mettre à jour la note existante -->
    <form method="POST" action="{{ route('notes.mettreAJour', $note->id) }}" style="max-width: 600px; margin: 0 auto;">
        @csrf
        <!-- Jeton CSRF pour la sécurité (obligatoire avec POST) -->

        @method('PUT')
        <!-- Spécifie qu'on fait une requête de type PUT (mise à jour) -->

        <!-- Sélection du client lié à la note -->
        <div style="margin-bottom: 20px;">
            <label for="client_id" style="font-weight: bold;">Client :</label>
            <select name="client_id" id="client_id" required style="width: 100%; padding: 8px;">
                <option value="">-- Choisir un client --</option>
                @foreach ($clients as $client)
                    <!-- On garde le client sélectionné grâce à la condition -->
                    <option value="{{ $client->id }}" {{ $note->client_id == $client->id ? 'selected' : '' }}>
                        {{ $client->nom }}
                    </option>
                @endforeach
            </select>
        </div>

        <!-- Zone de texte pour modifier le contenu de la note -->
        <div style="margin-bottom: 20px;">
            <label for="contenu" style="font-weight: bold;">Contenu :</label>
            <textarea name="contenu" id="contenu" rows="5" required
                      style="width: 100%; padding: 10px;">{{ old('contenu', $note->contenu) }}</textarea>
            <!-- On utilise old() pour garder le texte en cas d'erreur, sinon on affiche la valeur actuelle -->
        </div>

        <!-- Choix de la couleur du post-it -->
        <div style="margin-bottom: 20px;">
            <label for="couleur" style="font-weight: bold;">Couleur :</label>
            <input type="color" name="couleur" id="couleur"
                   value="{{ old('couleur', $note->couleur ?? '#ffff88') }}"
                   style="width: 100%; height: 40px; border: none; padding: 0;">
            <!-- Le champ input de type "color" permet de choisir une couleur facilement -->
            <!-- On met une valeur par défaut (#ffff88) si aucune couleur n’est encore définie -->
        </div>

        <!-- Bouton pour enregistrer les modifications -->
        <div style="text-align: center;">
            <button type="submit"
                    style="padding: 10px 20px; background-color: #007bff; color: white; border: none; border-radius: 5px; font-weight: bold; cursor: pointer;">
                💾 Enregistrer les modifications
            </button>
        </div>
    </form>

    <!-- Lien de retour vers la liste des notes -->
    <div style="text-align: center; margin-top: 20px;">
        <a href="{{ route('notes.index') }}" style="text-decoration: none; font-weight: bold;">
            ⬅️ Retour à la liste des notes
        </a>
    </div>

@endsection
