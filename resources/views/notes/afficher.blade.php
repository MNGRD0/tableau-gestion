@extends('layouts.app') 
<!-- On utilise le layout général du site (layouts/app.blade.php) -->

@section('content')
    <!-- Titre centré de la page -->
    <h1 style="text-align: center;">Détail de la note</h1>

    <!-- Bloc contenant les infos de la note -->
    <div style="max-width: 600px; margin: 30px auto; background-color: white; border-radius: 8px; padding: 25px; box-shadow: 0 0 10px rgba(0,0,0,0.1);">

        <!-- Nom du client (lien vers sa fiche) -->
        <p><strong>Client :</strong>
            <a href="{{ route('clients.afficher', $note->client->id) }}" 
               style="text-decoration: underline; font-weight: bold;">
                {{ $note->client->nom }}
            </a>
        </p>

        <!-- Contenu de la note -->
        <p><strong>Contenu :</strong> {{ $note->contenu }}</p>

        <!-- Date de création de la note (formatée à la française) -->
        <p><strong>Date :</strong> {{ $note->created_at->format('d/m/Y H:i') }}</p>
    </div>

    <!-- Lien de retour vers la liste des notes -->
    <div style="text-align: center;">
        <a href="{{ route('notes.index') }}" style="text-decoration: none; font-weight: bold;">
            ⬅️ Retour à la liste
        </a>
    </div>
@endsection
