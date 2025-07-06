@extends('layouts.app')
<!-- On hérite du layout principal (layouts/app.blade.php) contenant le header, le menu, etc. -->

@section('content')
<!-- Début du contenu principal spécifique à cette page -->

<h1 style="text-align: center;">Ajouter un rendez-vous</h1>

{{-- Affichage des erreurs de validation si le formulaire a échoué --}}
@if ($errors->any())
    <div style="background-color: #f8d7da; color: #721c24; padding: 10px; border-radius: 5px; margin-bottom: 20px;">
        <ul style="margin: 0; padding-left: 20px;">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
            <!-- Laravel stocke les erreurs dans $errors automatiquement si la validation échoue.
                 La méthode all() retourne toutes les erreurs en tableau.
                 Chaque <li> affiche une erreur -->
        </ul>
    </div>
@endif

<!-- Formulaire d'ajout d’un nouveau rendez-vous -->
<form method="POST" action="{{ route('rdv.enregistrer') }}" style="max-width: 600px; margin: 0 auto;">
    @csrf
    <!-- Protection contre les attaques CSRF (obligatoire avec POST) -->

    <!-- Sélection du client concerné -->
    <div style="margin-bottom: 15px;">
        <label for="client_id">Client :</label><br>
        <select name="client_id" id="client_id" required style="width: 100%; padding: 8px;">
            <option value="">-- Sélectionner un client --</option>
            @foreach($clients as $client)
                <option value="{{ $client->id }}">{{ $client->nom }}</option>
            @endforeach
            <!-- On boucle sur tous les clients pour les proposer dans la liste déroulante -->
        </select>
    </div>

    <!-- Champ de date + heure -->
    <div style="margin-bottom: 15px;">
        <label for="date">Date et heure :</label><br>
        <input type="datetime-local" name="date" id="date" required style="width: 100%; padding: 8px;">
        <!-- Ce champ génère un calendrier + une horloge dans le navigateur -->
    </div>

    <!-- Lieu du rendez-vous -->
    <div style="margin-bottom: 15px;">
        <label for="lieu">Lieu :</label><br>
        <input type="text" name="lieu" id="lieu" required style="width: 100%; padding: 8px;">
    </div>

    <!-- Statut du rendez-vous (ENUM) -->
    <div style="margin-bottom: 15px;">
        <label for="statut_rdv">Statut :</label><br>
        <select name="statut_rdv" id="statut_rdv" required style="width: 100%; padding: 8px;">
            <option value="à venir">À venir</option>
            <option value="en cours">En cours</option>
            <option value="passé">Passé</option>
        </select>
        <!-- Ces valeurs doivent correspondre aux options définies dans ta base de données (ENUM dans la migration) -->
    </div>

    <!-- Commentaire optionnel -->
    <div style="margin-bottom: 15px;">
        <label for="commentaire_rdv">Commentaire :</label><br>
        <textarea name="commentaire_rdv" id="commentaire_rdv" rows="4" style="width: 100%; padding: 8px;"></textarea>
        <!-- Zone de texte libre pour ajouter une remarque sur le rendez-vous -->
    </div>

    <!-- Bouton de validation -->
    <div style="text-align: right;">
        <button type="submit"
                style="padding: 10px 15px; background-color: rgb(22, 201, 22); color: white; border: none; border-radius: 5px; font-weight: bold; cursor: pointer;">
            ➕ Ajouter
        </button>
    </div>
</form>

@endsection
