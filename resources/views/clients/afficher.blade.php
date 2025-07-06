@extends('layouts.app')
<!-- Hérite du layout principal app.blade.php -->

@section('content')
    <h1 style="text-align: center;">Détails du client</h1>
    <!-- Titre centré pour présenter la page -->

    <main style="max-width: 600px; margin: 30px auto; background-color: white; border-radius: 8px; padding: 25px; box-shadow: 0 0 10px rgba(0,0,0,0.1);">
        <!-- Balise <main> : indique que c'est le contenu principal de la page pour l’accessibilité -->
        
        <p><strong>Nom :</strong> {{ $client->nom }}</p>
        <p><strong>Email :</strong> {{ $client->email_client }}</p>
        <p><strong>Téléphone :</strong> {{ $client->telephone_client }}</p>
        <p><strong>Adresse :</strong> {{ $client->adresse_client }}</p>
        <p><strong>Code postal :</strong> {{ $client->cp_client }}</p>
        <p><strong>Ville :</strong> {{ $client->ville_client }}</p>
        <p><strong>Note :</strong> {{ $client->commentaire_client ?? 'Aucune' }}</p>
        <!-- On affiche les infos du client. Si le commentaire est vide, on affiche "Aucune" -->
    </main>

    <div style="display: flex; justify-content: center; gap: 15px; margin-top: 20px;">
        <!-- Deux boutons côte à côte : retour et modifier -->

        <a href="{{ route('clients.index') }}"
           style="padding: 10px 15px; background-color: #007bff; color: white; text-decoration: none; border-radius: 5px; font-weight: bold; cursor: pointer;">
            ⬅️ Retour à la liste
        </a>
        <!-- Lien pour revenir à la liste des clients -->

        <a href="{{ route('clients.modifier', $client->id) }}"
           style="padding: 10px 15px; background-color: orange; color: white; text-decoration: none; border-radius: 5px; font-weight: bold; cursor: pointer;">
            ✏️ Modifier
        </a>
        <!-- Lien pour modifier les infos de ce client -->
    </div>
@endsection
