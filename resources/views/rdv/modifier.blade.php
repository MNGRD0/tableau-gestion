@extends('layouts.app')
<!-- On utilise le layout général (layouts/app.blade.php) pour garder le même en-tête et le même pied de page -->

@section('content')
<!-- Début du contenu principal de la page -->

<h1 style="text-align: center;">Modifier le rendez-vous</h1>

{{-- Affichage des erreurs de validation si le formulaire est mal rempli --}}
@if ($errors->any())
    <div style="background-color: #f8d7da; color: #721c24; padding: 10px; border-radius: 5px; margin-bottom: 20px;">
        <ul style="margin: 0; padding-left: 20px;">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<!-- Formulaire d'édition d'un rendez-vous -->
<form method="POST" action="{{ route('rdv.mettre_a_jour', $rdv->id) }}" style="max-width: 600px; margin: 0 auto;">
    @csrf
    <!-- Protection CSRF : Laravel ajoute un token invisible pour empêcher les attaques par formulaire -->
    
    @method('PUT')
    <!-- Comme HTML ne gère que GET et POST, cette directive dit à Laravel qu'on veut faire une requête PUT -->

    <!-- Sélection du client concerné -->
    <div style="margin-bottom: 15px;">
        <label for="client_id">Client :</label><br>
        <select name="client_id" id="client_id" required style="width: 100%; padding: 8px;">
            @foreach($clients as $client)
                <option value="{{ $client->id }}" {{ $rdv->client_id == $client->id ? 'selected' : '' }}>
                    {{ $client->nom }}
                </option>
            @endforeach
        </select>
        <!-- On boucle sur la liste des clients, et on pré-sélectionne celui du rendez-vous avec un test -->
    </div>

    <!-- Date et heure du rendez-vous (au bon format pour l'input datetime-local) -->
    <div style="margin-bottom: 15px;">
        <label for="date">Date et heure :</label><br>
        <input type="datetime-local" name="date" id="date"
               value="{{ \Carbon\Carbon::parse($rdv->date)->format('Y-m-d\TH:i') }}"
               required style="width: 100%; padding: 8px;">
        <!-- On utilise Carbon pour convertir la date du rendez-vous dans un format lisible par l’input -->
    </div>

    <!-- Champ pour le lieu du rendez-vous -->
    <div style="margin-bottom: 15px;">
        <label for="lieu">Lieu :</label><br>
        <input type="text" name="lieu" id="lieu" value="{{ $rdv->lieu }}"
               required style="width: 100%; padding: 8px;">
    </div>

    <!-- Sélection du statut du rendez-vous (ENUM : à venir, en cours, passé) -->
    <div style="margin-bottom: 15px;">
        <label for="statut_rdv">Statut :</label><br>
        <select name="statut_rdv" id="statut_rdv" required style="width: 100%; padding: 8px;">
            <option value="à venir" {{ $rdv->statut_rdv === 'à venir' ? 'selected' : '' }}>À venir</option>
            <option value="en cours" {{ $rdv->statut_rdv === 'en cours' ? 'selected' : '' }}>En cours</option>
            <option value="passé" {{ $rdv->statut_rdv === 'passé' ? 'selected' : '' }}>Passé</option>
        </select>
        <!-- On pré-sélectionne ici le bon statut selon ce qui est déjà enregistré dans la base -->
    </div>

    <!-- Zone de texte pour écrire un commentaire (optionnel) -->
    <div style="margin-bottom: 15px;">
        <label for="commentaire_rdv">Commentaire :</label><br>
        <textarea name="commentaire_rdv" id="commentaire_rdv" rows="4" style="width: 100%; padding: 8px;">{{ $rdv->commentaire_rdv }}</textarea>
    </div>

    <!-- Bouton de soumission -->
    <div style="text-align: right;">
        <button type="submit"
                style="padding: 10px 15px; background-color: orange; color: white; border: none; border-radius: 5px; font-weight: bold; cursor: pointer;">
            💾 Mettre à jour
        </button>
    </div>
</form>

@endsection
