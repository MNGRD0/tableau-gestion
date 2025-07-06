@extends('layouts.app')
<!-- On hérite du layout général 'layouts/app.blade.php' -->

@section('content')
<!-- Contenu principal de la page -->

<h1 style="text-align: center;">Détails de la facture</h1>
<!-- Titre principal au centre -->

<div style="max-width: 600px; margin: 30px auto; background-color: white; border-radius: 8px; padding: 25px; box-shadow: 0 0 10px rgba(0,0,0,0.1);">
    <!-- Conteneur stylé avec ombre, centré et bord arrondi -->

    <p><strong>Client :</strong>
        <a href="{{ route('clients.afficher', $facture->client->id) }}"
           style="color: #007acc; text-decoration: underline; font-weight: bold;">
           <!-- Lien vers la fiche client (clicable) avec son nom -->
            {{ $facture->client->nom }}
        </a>
    </p>

    <p><strong>Montant :</strong> {{ $facture->montant }} €</p>
    <!-- Affiche le montant de la facture -->

    <p><strong>Moyen de paiement :</strong> {{ $facture->moyen_paiement }}</p>
    <!-- Affiche le moyen de paiement utilisé -->

    <p><strong>Échelonné :</strong> {{ $facture->echelonner ? 'Oui' : 'Non' }}</p>
    <!-- Si "echelonner" = true (1), affiche "Oui", sinon "Non" -->

    <p><strong>Statut :</strong> {{ $facture->statut_facture }}</p>
    <!-- Affiche le statut : payée ou non payée -->

    <p><strong>Commentaire :</strong> {{ $facture->commentaire_facture ?? 'Aucun' }}</p>
    <!-- Affiche le commentaire s’il y en a, sinon "Aucun" -->
</div>

<div style="text-align: center; margin-top: 20px;">
    <!-- Boutons d'action au centre -->

    <a href="{{ route('factures.index') }}"
       style="padding: 10px 15px; background-color: #007bff; color: white; text-decoration: none; border-radius: 5px; font-weight: bold; cursor: pointer;">
        ⬅️ Retour à la liste
    </a>
    <!-- Retour à la page de toutes les factures -->

    <a href="{{ route('factures.modifier', $facture->id) }}"
       style="padding: 10px 15px; background-color: orange; color: white; text-decoration: none; border-radius: 5px; font-weight: bold; margin-left: 15px;">
        ✏️ Modifier
    </a>
    <!-- Bouton pour aller modifier cette facture -->

    <a href="{{ route('factures.pdf', $facture->id) }}"
       style="padding: 10px 15px; background-color:rgb(165, 165, 165); color: white; text-decoration: none; border-radius: 5px; font-weight: bold; cursor: pointer; margin-left: 10px;">
        📄 Générer PDF
    </a>
    <!-- Lien pour générer un PDF de la facture -->
</div>

@endsection
