@extends('layouts.app')

@section('content')
<h1 style="text-align: center;">Détails de la facture</h1>

<div style="max-width: 600px; margin: 30px auto; background-color: white; border-radius: 8px; padding: 25px; box-shadow: 0 0 10px rgba(0,0,0,0.1);">
    <p><strong>Client :</strong>
        <a href="{{ route('clients.afficher', $facture->client->id) }}"
           style="color: #007acc; text-decoration: underline; font-weight: bold;">
            {{ $facture->client->nom }}
        </a>
    </p>
    <p><strong>Montant :</strong> {{ $facture->montant }} €</p>
    <p><strong>Moyen de paiement :</strong> {{ $facture->moyen_paiement }}</p>
    <p><strong>Échelonné :</strong> {{ $facture->echelonner ? 'Oui' : 'Non' }}</p>
    <p><strong>Statut :</strong> {{ $facture->statut_facture }}</p>
    <p><strong>Commentaire :</strong> {{ $facture->commentaire_facture ?? 'Aucun' }}</p>
</div>

<div style="text-align: center; margin-top: 20px;">
    <a href="{{ route('factures.index') }}"
       style="padding: 10px 15px; background-color: #007bff; color: white; text-decoration: none; border-radius: 5px; font-weight: bold; cursor: pointer;">
        ⬅️ Retour à la liste
    </a>

    <a href="{{ route('factures.modifier', $facture->id) }}"
       style="padding: 10px 15px; background-color: orange; color: white; text-decoration: none; border-radius: 5px; font-weight: bold; margin-left: 15px;">
        ✏️ Modifier
    </a>
    <a href="{{ route('factures.pdf', $facture->id) }}"
       style="padding: 10px 15px; background-color:rgb(165, 165, 165); color: white; text-decoration: none; border-radius: 5px; font-weight: bold; cursor: pointer; margin-left: 10px;">
        📄 Générer PDF
    </a>
</div>
@endsection
