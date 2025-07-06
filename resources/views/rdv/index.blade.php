@extends('layouts.app')
<!-- On utilise le layout principal du site (layouts/app.blade.php) -->

@php use Illuminate\Support\Str; @endphp
<!-- On importe la classe Str pour utiliser des fonctions utiles, comme raccourcir un texte avec Str::limit() -->

@section('content')
<!-- Début de la section de contenu spécifique à cette page -->

{{-- ✅ Message de succès après une action réussie (ex : suppression ou ajout) --}}
@if(session('succes'))
    <div style="background-color: #d4edda; color: #155724; padding: 10px; border-radius: 5px; margin-bottom: 20px; text-align: center;">
        {{ session('succes') }}
    </div>
@endif

<h1 style="text-align: center;">Liste des rendez-vous</h1>

<!-- Affiche le nombre total de rendez-vous chargés -->
<p>Nombre de rendez-vous : {{ $rdvs->count() }}</p>

<!-- Formulaire de filtre par statut (à venir, en cours, passé) -->
<form method="GET" action="{{ route('rdv.index') }}">
    <label for="filtre">Filtrer par statut :</label>
    <select name="filtre" id="filtre" onchange="this.form.submit()">
        <option value="">-- Tous --</option>
        <option value="à venir" {{ $filtre === 'à venir' ? 'selected' : '' }}>À venir</option>
        <option value="en cours" {{ $filtre === 'en cours' ? 'selected' : '' }}>En cours</option>
        <option value="passé" {{ $filtre === 'passé' ? 'selected' : '' }}>Passé</option>
    </select>
</form>

<!-- Bouton pour ajouter un nouveau rendez-vous -->
<div style="margin-bottom: 20px; text-align: right; margin-top: -30px;" class="ajouterBtn">
    <a href="{{ route('rdv.creer') }}"
       style="padding: 10px 15px; background-color: rgb(22, 201, 22); color: white; text-decoration: none; border-radius: 5px; font-weight: bold; cursor: pointer;">
        + Ajouter un rendez-vous
    </a>
</div>

<!-- Style spécifique pour adapter le tableau aux petits écrans (mobile responsive) -->
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

        table td:last-child {
            border-bottom: none;
        }

        table td::before {
            content: attr(data-label); /* Affiche un libellé avant la valeur dans le <td> */
            font-weight: bold;
            color: #555;
        }

        form {
            margin-bottom: 70px;
        }
    }
</style>

<!-- Tableau affichant tous les rendez-vous -->
<table border="1" cellpadding="8" cellspacing="0" style="margin: 0 auto; width: 90%; margin-top: 50px;">
    <thead>
        <tr>
            <th>Client</th>
            <th>Date</th>
            <th>Lieu</th>
            <th>Statut</th>
            <th>Commentaire</th>
            <th>Actions</th>
        </tr>
    </thead>

    <tbody>
    @forelse ($rdvs as $rdv)
        <tr>
            <!-- Nom du client (avec lien vers sa fiche) -->
            <td data-label="Client">
                <a href="{{ route('clients.afficher', $rdv->client->id) }}"
                   style="color: #007acc; text-decoration: underline; font-weight: bold;">
                    {{ $rdv->client->nom }}
                </a>
            </td>

            <!-- Date brute affichée (tu peux aussi la formater si tu préfères) -->
            <td data-label="Date">{{ $rdv->date }}</td>

            <!-- Lieu tronqué à 19 caractères pour éviter d’allonger la ligne -->
            <td data-label="Lieu">{{ Str::limit($rdv->lieu, 19, '...') }}</td>

            <!-- Statut tel que défini dans ta base de données (ENUM) -->
            <td data-label="Statut">{{ $rdv->statut_rdv }}</td>

            <!-- Commentaire tronqué aussi -->
            <td data-label="Commentaire">{{ Str::limit($rdv->commentaire_rdv, 19, '...') }}</td>

            <!-- Actions (afficher, modifier, supprimer) -->
            <td data-label="Actions" style="text-align: center;">
                <!-- 👁️ Voir le détail -->
                <a href="{{ route('rdv.afficher', $rdv->id) }}" title="Afficher"
                   style="color: green; font-size: 16px; margin: 0 5px; text-decoration: none;">👁️</a>

                <span style="color: #ccc;">|</span>

                <!-- ✏️ Modifier -->
                <a href="{{ route('rdv.modifier', $rdv->id) }}" title="Modifier"
                   style="color: orange; font-size: 16px; margin: 0 5px; text-decoration: none;">✏️</a>

                <span style="color: #ccc;">|</span>

                <!-- ➖ Supprimer (formulaire POST avec méthode DELETE pour respecter Laravel) -->
                <form action="{{ route('rdv.supprimer', $rdv->id) }}" method="POST" style="display:inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" title="Supprimer"
                            onclick="return confirm('Supprimer ce rendez-vous ?')"
                            style="color: red; background: none; border: none; font-size: 16px; cursor: pointer; text-decoration: none;">
                        ➖
                    </button>
                </form>
            </td>
        </tr>
    @empty
        <!-- Message si aucun rendez-vous trouvé -->
        <tr>
            <td colspan="6">Aucun rendez-vous trouvé.</td>
        </tr>
    @endforelse
    </tbody>
</table>

<!-- Si beaucoup de rendez-vous, on propose d’en voir plus ou de réduire l'affichage -->
@if($rdvs->count() > 10)
    <div style="text-align: center; margin-top: 20px;">
        @if($mode === 'tout')
            <!-- Lien pour afficher moins -->
            <a href="{{ route('rdv.index') }}"
               style="color: #007bff; text-decoration: underline; font-weight: bold;">
                🔙 Réduire la liste
            </a>
        @else
            <!-- Lien pour afficher tous les rendez-vous (on garde le filtre actuel si besoin) -->
            <a href="{{ route('rdv.index', ['filtre' => $filtre, 'mode' => 'tout']) }}"
               style="color: #007bff; text-decoration: underline; font-weight: bold;">
                ➕ Afficher tous les rendez-vous
            </a>
        @endif
    </div>
@endif

<!-- Lien vers la corbeille (liste des rendez-vous supprimés) -->
@if($rdvs->count() >= 0)
<div style="text-align: center; margin-top: 20px;">
    <a href="{{ route('rdv.supprimes') }}" style="text-decoration: none; color: red; font-weight: bold;">
        🗑️ Voir les rendez-vous supprimés
    </a>
</div>
@endif

@endsection
