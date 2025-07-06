@extends('layouts.app')
<!-- On utilise le layout commun layouts/app.blade.php (en-tête, menu, pied de page) -->

@php
    use Illuminate\Support\Str;
@endphp
<!-- On utilise ici la classe Str de Laravel pour raccourcir les textes (ex: commentaire limité à 19 caractères) -->

@section('content')

@if(session('succes'))
    <!-- Si un message "succes" existe dans la session (ex: après création ou modification d’une facture), on l'affiche -->
    <div style="background-color: #d4edda; color: #155724; padding: 10px; border-radius: 5px; margin-bottom: 20px; text-align: center;">
        {{ session('succes') }}
    </div>
@endif

<h1 style="text-align: center;">Liste des factures</h1>

<!-- Affiche le nombre total de factures reçues depuis le contrôleur -->
<p>Nombre de factures : {{ $factures->count() }}</p>

<!-- Formulaire GET pour filtrer les factures selon leur statut (payée ou non payée) -->
<form method="GET" action="{{ route('factures.index') }}">
    <label for="filtre">Filtrer par statut :</label>
    <select name="filtre" id="filtre" onchange="this.form.submit()">
        <option value="">-- Toutes --</option>
        <option value="payée" {{ $filtre === 'payée' ? 'selected' : '' }}>Payée</option>
        <option value="non payée" {{ $filtre === 'non payée' ? 'selected' : '' }}>Non payée</option>
    </select>
</form>

<!-- Bouton d’ajout d’une nouvelle facture -->
<div style="margin-bottom: 20px; text-align: right; margin-top: -30px;" class="ajouterBtn">
    <a href="{{ route('factures.creer') }}"
       style="padding: 10px 15px; background-color: rgb(22, 201, 22); color: white; text-decoration: none; border-radius: 5px; font-weight: bold; cursor: pointer;">
        + Ajouter une facture
    </a>
</div>

<!-- Responsive design pour le tableau -->
<style>
    th {
        background: linear-gradient(90deg, rgb(208, 231, 255), rgb(125, 203, 255), rgb(144, 216, 245), rgb(194, 238, 255));
    }

    @media screen and (max-width: 768px) {
        table {
            width: 100%;
            display: block;
            overflow-x: auto;
            white-space: nowrap;
        }

        table thead {
            display: none;
        }

        table tr {
            display: block;
            border: 1px solid #ccc;
            margin-bottom: 10px;
            padding: 10px;
        }

        table td {
            display: flex;
            justify-content: space-between;
            padding: 8px 10px;
            border-bottom: 1px solid #eee;
        }

        table td::before {
            content: attr(data-label);
            font-weight: bold;
            color: #555;
        }
    }
</style>

<!-- Tableau des factures -->
<table border="1" cellpadding="8" cellspacing="0" style="margin: 0 auto; width: 90%; margin-top: 50px;">
    <thead>
        <tr>
            <th>Client</th>
            <th>Montant</th>
            <th>Paiement</th>
            <th>Échelonné</th>
            <th>Statut</th>
            <th>Commentaire</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        @forelse ($factures as $facture)
            <tr>
                <!-- On affiche un lien vers la fiche client -->
                <td data-label="Client">
                    <a href="{{ route('clients.afficher', $facture->client->id) }}"
                       style="color: #007acc; text-decoration: underline; font-weight: bold;">
                        {{ $facture->client->nom }}
                    </a>
                </td>
                <td data-label="Montant">{{ $facture->montant }} €</td>
                <td data-label="Paiement">{{ $facture->moyen_paiement }}</td>
                <td data-label="Échelonné">{{ $facture->echelonner ? 'Oui' : 'Non' }}</td>
                <td data-label="Statut">{{ $facture->statut_facture }}</td>
                <!-- On limite le texte du commentaire à 19 caractères -->
                <td data-label="Commentaire">{{ Str::limit($facture->commentaire_facture, 19, '...') }}</td>

                <!-- Actions : afficher, modifier, supprimer, télécharger PDF -->
                <td data-label="Actions" style="text-align: center;">
                    <!-- 👁️ Voir la facture -->
                    <a href="{{ route('factures.afficher', $facture->id) }}" title="Afficher"
                       style="color: green; font-size: 16px; margin: 0 5px; text-decoration: none;">👁️</a>

                    <span style="color: #ccc;">|</span>

                    <!-- ✏️ Modifier -->
                    <a href="{{ route('factures.modifier', $facture->id) }}" title="Modifier"
                       style="color: orange; font-size: 16px; margin: 0 5px; text-decoration: none;">✏️</a>

                    <span style="color: #ccc;">|</span>

                    <!-- ➖ Supprimer (soft delete) -->
                    <form action="{{ route('factures.supprimer', $facture->id) }}" method="POST" style="display:inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" title="Supprimer"
                                onclick="return confirm('Supprimer cette facture ?')"
                                style="color: red; background: none; border: none; font-size: 16px; cursor: pointer; text-decoration: none;">
                            ➖
                        </button>

                        <span style="color: #ccc;">|</span>

                        <!-- 📄 Télécharger PDF -->
                        <a href="{{ route('factures.pdf', $facture->id) }}" title="Télécharger PDF"
                           style="color: blue; font-size: 16px; margin: 0 5px; text-decoration: none;">📄</a>
                    </form>
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="7">Aucune facture trouvée.</td>
            </tr>
        @endforelse
    </tbody>
</table>

<!-- Liens pour changer le mode d’affichage -->
@if($factures->count() > 10)
    <div style="text-align: center; margin-top: 20px;">
        @if($mode === 'tout')
            <!-- Si le mode est "tout", on propose de réduire -->
            <a href="{{ route('factures.index') }}"
               style="color: #007bff; text-decoration: underline; font-weight: bold;">
                🔙 Réduire la liste
            </a>
        @else
            <!-- Sinon on propose d'afficher tout -->
            <a href="{{ route('factures.index', ['filtre' => $filtre, 'mode' => 'tout']) }}"
               style="color: #007bff; text-decoration: underline; font-weight: bold;">
                ➕ Afficher toutes les factures
            </a>
        @endif
    </div>
@endif

<!-- Lien vers la liste des factures supprimées -->
@if($factures->count() >= 0)
    <div style="text-align: center; margin-top: 20px;">
        <a href="{{ route('factures.supprimees') }}"
           style="text-decoration: none; color: red; font-weight: bold;">
            🗑️ Voir les factures supprimées
        </a>
    </div>
@endif

@endsection
