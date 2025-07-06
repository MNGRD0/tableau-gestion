@extends('layouts.app')
<!-- On hérite du layout principal (layouts/app.blade.php), qui contient l’en-tête, le menu, le pied de page, etc. -->

@section('content')
<!-- Section du contenu principal affiché dans le layout -->

<h1 style="text-align: center;">Détails du rendez-vous</h1>

<!-- Carte contenant les informations du rendez-vous -->
<div style="max-width: 600px; margin: 30px auto; background: #f5faff; padding: 20px; border-radius: 8px; box-shadow: 0 0 10px rgba(0,0,0,0.1);">

    <!-- Affichage du nom du client avec lien vers sa fiche -->
    <p>
        <strong style="color: #007acc;">Client :</strong> 
        <a href="{{ route('clients.afficher', $rdv->client->id) }}" 
           style="color: #007acc; font-weight: bold; text-decoration: underline;">
            {{ $rdv->client->nom }}
        </a>
        <!-- Grâce à la relation définie dans le modèle Rdv (belongsTo Client), on accède ici au nom du client via $rdv->client->nom -->
    </p>

    <!-- Affichage de la date du rendez-vous -->
    <p>
        <strong style="color: #007acc;">Date :</strong> 
        {{ \Carbon\Carbon::parse($rdv->date)->format('d/m/Y à H\hi') }}
        <!-- On formate la date avec Carbon pour l’afficher de manière lisible (jour/mois/année heure:minute) -->
    </p>

    <!-- Lieu du rendez-vous -->
    <p>
        <strong style="color: #007acc;">Lieu :</strong> {{ $rdv->lieu }}
    </p>

    <!-- Statut du rendez-vous (ex : à venir, en cours...) -->
    <p>
        <strong style="color: #007acc;">Statut :</strong> {{ ucfirst($rdv->statut_rdv) }}
        <!-- ucfirst() met la première lettre en majuscule (ex : "en cours" → "En cours") -->
    </p>

    <!-- Commentaire éventuel du rendez-vous, ou un tiret s’il n’y en a pas -->
    <p>
        <strong style="color: #007acc;">Commentaire :</strong> {{ $rdv->commentaire_rdv ?? '—' }}
        <!-- Si aucun commentaire n'est renseigné, on affiche simplement un tiret -->
    </p>
</div>

<!-- Lien de retour vers la liste des rendez-vous -->
<div style="text-align: center; margin: 20px auto; max-width: 600px;">
    <a href="{{ route('rdv.index') }}"
       style="text-decoration: none; color: white; background-color: #007acc; padding: 10px 15px; border-radius: 5px; font-weight: bold;">
        ⬅️ Retour à la liste
    </a>
</div>

@endsection
