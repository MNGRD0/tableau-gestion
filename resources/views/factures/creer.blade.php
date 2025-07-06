@extends('layouts.app')
<!-- On utilise le layout principal "layouts/app.blade.php" -->

@section('content')
<!-- Début du contenu principal -->

<h1 style="text-align: center;">Ajouter une facture</h1>
<!-- Titre de la page -->

<div style="max-width: 600px; margin: 30px auto; background-color: white; border-radius: 8px; padding: 25px; box-shadow: 0 0 10px rgba(0,0,0,0.1);">
    <!-- Bloc contenant le formulaire centré, avec un fond blanc et un peu de style -->

    <form method="POST" action="{{ route('factures.enregistrer') }}">
        <!-- Envoie le formulaire vers la route nommée "factures.enregistrer" (gérée dans le contrôleur) -->
        @csrf
        <!-- Jeton CSRF obligatoire pour protéger l’envoi du formulaire -->

        <!-- Champ : sélection du client -->
        <label for="client_id"><strong>Client :</strong></label>
        <select name="client_id" id="client_id" required>
            <!-- Menu déroulant pour choisir un client -->
            <option value="">-- Sélectionner un client --</option>
            @foreach($clients as $client)
                <option value="{{ $client->id }}">{{ $client->nom }}</option>
                <!-- Pour chaque client, on crée une option dans la liste -->
            @endforeach
        </select><br><br>

        <!-- Champ : montant -->
        <label for="montant"><strong>Montant (€) :</strong></label>
        <input type="number" step="0.01" name="montant" id="montant" required>
        <!-- Champ pour écrire le montant avec des centimes -->
        <br><br>

        <!-- Champ : moyen de paiement -->
        <label for="moyen_paiement"><strong>Moyen de paiement :</strong></label>
        <select name="moyen_paiement" id="moyen_paiement" required>
            <option value="">-- Choisir --</option>
            <option value="chèque">Chèque</option>
            <option value="espèces">Espèces</option>
            <option value="carte bancaire">Carte bancaire</option>
            <option value="autre">Autre</option>
        </select><br><br>

        <!-- Champ : coche si la facture est échelonnée -->
        <label for="echelonner"><strong>Échelonné :</strong></label>
        <input type="checkbox" name="echelonner" id="echelonner">
        <!-- Si coché, la case "echelonner" sera transmise comme "on" dans la requête -->
        <br><br>

        <!-- Champ : statut (payée ou non) -->
        <label for="statut_facture"><strong>Statut :</strong></label>
        <select name="statut_facture" id="statut_facture" required>
            <option value="non payée">Non payée</option>
            <option value="payée">Payée</option>
        </select><br><br>

        <!-- Champ : commentaire facultatif -->
        <label for="commentaire_facture"><strong>Commentaire :</strong></label><br>
        <textarea name="commentaire_facture" id="commentaire_facture" rows="3" style="width: 100%; resize: none;"></textarea>
        <!-- Zone de texte pour ajouter un commentaire facultatif -->
        <br><br>

        <!-- Bouton de validation -->
        <div style="text-align: center;">
            <button type="submit"
                    style="padding: 10px 15px; background-color: rgb(22, 201, 22); color: white; border: none; border-radius: 5px; font-weight: bold; cursor: pointer;">
                💾 Enregistrer
            </button>
        </div>
    </form>
</div>

<!-- Lien de retour à la liste des factures -->
<div style="text-align: center; margin-top: 20px;">
    <a href="{{ route('factures.index') }}"
       style="color: #007bff; text-decoration: underline; font-weight: bold;">
        ⬅️ Retour à la liste des factures
    </a>
</div>

@endsection
