@extends('layouts.app')

@section('content')
<h1 style="text-align: center;">Modifier la facture</h1>

<div style="max-width: 600px; margin: 0 auto;">
    <form action="{{ route('factures.mettreAJour', $facture->id) }}" method="POST"
          style="background-color: white; padding: 25px; border-radius: 10px; box-shadow: 0 0 10px rgba(0,0,0,0.1);">
        @csrf
        @method('PUT')

        {{-- Client (désactivé) --}}
        <div style="margin-bottom: 15px;">
            <label>Client :</label><br>
            <input type="text" value="{{ $facture->client->nom }}" disabled
                   style="width: 100%; padding: 8px;" />
        </div>

        {{-- Montant --}}
        <div style="margin-bottom: 15px;">
            <label>Montant (€) :</label>
            <input type="number" name="montant" step="0.01" required value="{{ $facture->montant }}"
                   style="width: 100%; padding: 8px;" />
        </div>

        {{-- Moyen de paiement --}}
        <div style="margin-bottom: 15px;">
            <label>Moyen de paiement :</label>
            <select name="moyen_paiement" required style="width: 100%; padding: 8px;">
                <option value="chèque" {{ $facture->moyen_paiement == 'chèque' ? 'selected' : '' }}>Chèque</option>
                <option value="espèces" {{ $facture->moyen_paiement == 'espèces' ? 'selected' : '' }}>Espèces</option>
                <option value="carte bancaire" {{ $facture->moyen_paiement == 'carte bancaire' ? 'selected' : '' }}>Carte bancaire</option>
                <option value="autre" {{ $facture->moyen_paiement == 'autre' ? 'selected' : '' }}>Autre</option>
            </select>
        </div>

        {{-- Échelonné --}}
        <div style="margin-bottom: 15px;">
            <label>
                <input type="checkbox" name="echelonner" {{ $facture->echelonner ? 'checked' : '' }} />
                Échelonné
            </label>
        </div>

        {{-- Statut --}}
        <div style="margin-bottom: 15px;">
            <label>Statut :</label>
            <select name="statut_facture" required style="width: 100%; padding: 8px;">
                <option value="payée" {{ $facture->statut_facture == 'payée' ? 'selected' : '' }}>Payée</option>
                <option value="non payée" {{ $facture->statut_facture == 'non payée' ? 'selected' : '' }}>Non payée</option>
            </select>
        </div>

        {{-- Commentaire --}}
        <div style="margin-bottom: 15px;">
            <label>Commentaire :</label>
            <textarea name="commentaire_facture" rows="3" style="width: 100%; padding: 8px;">{{ $facture->commentaire_facture }}</textarea>
        </div>

        <div style="text-align: center;">
            <button type="submit"
                    style="padding: 10px 20px; background-color: orange; color: white; border: none; border-radius: 5px; font-weight: bold; cursor: pointer;">
                💾 Enregistrer les modifications
            </button>
        </div>
    </form>
</div>
@endsection
