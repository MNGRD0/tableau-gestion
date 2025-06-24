@extends('layouts.app')

@section('content')
    <h1 style="text-align: center;">Ajouter une facture</h1>

    <div style="max-width: 600px; margin: 30px auto; background-color: white; border-radius: 8px; padding: 25px; box-shadow: 0 0 10px rgba(0,0,0,0.1);">
        <form method="POST" action="{{ route('factures.enregistrer') }}">
            @csrf

            <label for="client_id"><strong>Client :</strong></label>
            <select name="client_id" required>
                <option value="">-- Sélectionner un client --</option>
                @foreach($clients as $client)
                    <option value="{{ $client->id }}">{{ $client->nom }}</option>
                @endforeach
            </select><br><br>

            <label for="montant"><strong>Montant (€) :</strong></label>
            <input type="number" step="0.01" name="montant" required><br><br>

            <label for="moyen_paiement"><strong>Moyen de paiement :</strong></label>
            <select name="moyen_paiement" required>
                <option value="">-- Choisir --</option>
                <option value="chèque">Chèque</option>
                <option value="espèces">Espèces</option>
                <option value="carte bancaire">Carte bancaire</option>
                <option value="autre">Autre</option>
            </select><br><br>

            <label for="echelonner"><strong>Échelonné :</strong></label>
            <input type="checkbox" name="echelonner"><br><br>

            <label for="statut_facture"><strong>Statut :</strong></label>
            <select name="statut_facture" required>
            <option value="non payée">Non payée</option>
                <option value="payée">Payée</option>
            </select><br><br>

            <label for="commentaire_facture"><strong>Commentaire :</strong></label><br>
            <textarea name="commentaire_facture" rows="3" style="width: 100%; resize: none;"></textarea><br><br>

            <div style="text-align: center;">
                <button type="submit"
                        style="padding: 10px 15px; background-color: rgb(22, 201, 22); color: white; border: none; border-radius: 5px; font-weight: bold; cursor: pointer;">
                    💾 Enregistrer
                </button>
            </div>
        </form>
    </div>

    <div style="text-align: center; margin-top: 20px;">
        <a href="{{ route('factures.index') }}"
           style="color: #007bff; text-decoration: underline; font-weight: bold;">
            ⬅️ Retour à la liste des factures
        </a>
    </div>
@endsection
