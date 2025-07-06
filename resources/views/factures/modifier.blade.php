@extends('layouts.app')
<!-- On utilise le layout principal (layouts/app.blade.php) pour hériter du header, menu, etc. -->

@section('content')

<!-- Titre centré -->
<h1 style="text-align: center;">Modifier la facture</h1>

<!-- Conteneur central -->
<div style="max-width: 600px; margin: 0 auto;">

    <!-- Formulaire de modification -->
    <form action="{{ route('factures.mettreAJour', $facture->id) }}" method="POST"
          style="background-color: white; padding: 25px; border-radius: 10px; box-shadow: 0 0 10px rgba(0,0,0,0.1);">

        @csrf
        <!-- Jeton de sécurité obligatoire pour envoyer un formulaire POST -->

        @method('PUT')
        <!-- Laravel comprend ici qu'on veut faire une modification (PUT), même si le formulaire HTML est en POST -->

        {{-- Client affiché mais non modifiable --}}
        <div style="margin-bottom: 15px;">
            <label>Client :</label><br>
            <input type="text" value="{{ $facture->client->nom }}" disabled
                   style="width: 100%; padding: 8px;" />
            <!-- Champ affiché uniquement pour information (non modifiable) -->
        </div>

        {{-- Montant de la facture --}}
        <div style="margin-bottom: 15px;">
            <label>Montant (€) :</label>
            <input type="number" name="montant" step="0.01" required value="{{ $facture->montant }}"
                   style="width: 100%; padding: 8px;" />
            <!-- On autorise les décimales avec step="0.01" -->
        </div>

        {{-- Moyen de paiement --}}
        <div style="margin-bottom: 15px;">
            <label>Moyen de paiement :</label>
            <select name="moyen_paiement" required style="width: 100%; padding: 8px;">
                <!-- On pré-sélectionne l'option qui correspond à la facture -->
                <option value="chèque" {{ $facture->moyen_paiement == 'chèque' ? 'selected' : '' }}>Chèque</option>
                <option value="espèces" {{ $facture->moyen_paiement == 'espèces' ? 'selected' : '' }}>Espèces</option>
                <option value="carte bancaire" {{ $facture->moyen_paiement == 'carte bancaire' ? 'selected' : '' }}>Carte bancaire</option>
                <option value="autre" {{ $facture->moyen_paiement == 'autre' ? 'selected' : '' }}>Autre</option>
            </select>
        </div>

        {{-- Case à cocher : facture échelonnée ou non --}}
        <div style="margin-bottom: 15px;">
            <label>
                <input type="checkbox" name="echelonner" {{ $facture->echelonner ? 'checked' : '' }} />
                Échelonné
            </label>
        </div>

        {{-- Statut de la facture (payée ou non) --}}
        <div style="margin-bottom: 15px;">
            <label>Statut :</label>
            <select name="statut_facture" required style="width: 100%; padding: 8px;">
                <option value="payée" {{ $facture->statut_facture == 'payée' ? 'selected' : '' }}>Payée</option>
                <option value="non payée" {{ $facture->statut_facture == 'non payée' ? 'selected' : '' }}>Non payée</option>
            </select>
        </div>

        {{-- Commentaire libre --}}
        <div style="margin-bottom: 15px;">
            <label>Commentaire :</label>
            <textarea name="commentaire_facture" rows="3" style="width: 100%; padding: 8px;">
                {{ $facture->commentaire_facture }}
            </textarea>
        </div>

        {{-- Bouton pour valider les modifications --}}
        <div style="text-align: center;">
            <button type="submit"
                    style="padding: 10px 20px; background-color: orange; color: white; border: none; border-radius: 5px; font-weight: bold; cursor: pointer;">
                💾 Enregistrer les modifications
            </button>
        </div>
    </form>
</div>
@endsection
