@extends('layouts.app')
<!-- On utilise le layout général app.blade.php pour intégrer le header, le footer, etc. -->

@section('content')
<!-- Début du contenu principal -->

<h1 style="text-align: center;">Rendez-vous supprimés</h1>

{{-- Message de succès s’il y en a un dans la session (après restauration ou suppression) --}}
@if(session('succes'))
    <div style="background-color: #d4edda; color: #155724; padding: 10px; border-radius: 5px; margin: 20px auto; width: 80%; text-align: center;">
        {{ session('succes') }}
    </div>
@endif

<!-- ✅ Responsive pour mobiles : si écran petit, on adapte le tableau en version bloc -->
<style>
    @media screen and (max-width: 768px) {
        table {
            width: 100%;
            display: block;
            overflow-x: auto;
            white-space: nowrap;
        }

        table thead {
            display: none; /* En mode mobile, on ne montre pas les en-têtes */
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
            content: attr(data-label); /* Affiche le nom de la colonne comme une étiquette avant chaque champ */
            font-weight: bold;
            color: #555;
        }

        form {
            margin-bottom: 70px;
        }
    }
</style>

<!-- Tableau principal affichant les rendez-vous supprimés -->
<table border="1" cellpadding="8" cellspacing="0" style="margin: 0 auto; width: 90%; margin-top: 30px;">
    <thead>
        <tr>
            <th>Client</th>
            <th>Date</th>
            <th>Lieu</th>
            <th>Statut</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
    @forelse ($rdvs as $rdv)
        <tr>
            <!-- Le nom du client est déjà récupéré dans le contrôleur (nom_client) -->
            <td data-label="Client">{{ $rdv->nom_client }}</td>

            <!-- Date brute (tu pourrais utiliser Carbon ici pour l'améliorer si besoin) -->
            <td data-label="Date">{{ $rdv->date }}</td>

            <td data-label="Lieu">{{ $rdv->lieu }}</td>
            <td data-label="Statut">{{ $rdv->statut_rdv }}</td>

            <!-- Boutons d'action : restaurer et supprimer définitivement -->
            <td data-label="Actions" style="text-align: center;">
                {{-- Restaurer le rendez-vous (remet dans la liste active) --}}
                <form method="POST" action="{{ route('rdv.restaurer', $rdv->id) }}" style="display:inline;">
                    @csrf
                    <button type="submit" title="Restaurer" style="color: green; background: none; border: none; cursor: pointer;">🔄</button>
                </form>

                {{-- Supprimer définitivement (effacé de la base de données) --}}
                <form method="POST" action="{{ route('rdv.supprimer.definitivement', $rdv->id) }}" style="display:inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" title="Supprimer définitivement"
                            onclick="return confirm('Supprimer définitivement ce rendez-vous ?')"
                            style="color: red; background: none; border: none; cursor: pointer;">🧹</button>
                </form>
            </td>
        </tr>
    @empty
        <!-- Si aucun rendez-vous supprimé -->
        <tr>
            <td colspan="5" style="text-align: center; color: red;">Aucun rendez-vous supprimé.</td>
        </tr>
    @endforelse
    </tbody>
</table>

<!-- Lien pour revenir à la liste des rendez-vous actifs -->
<div style="text-align: center; margin-top: 30px;">
    <a href="{{ route('rdv.index') }}" style="text-decoration: none; font-weight: bold;">⬅️ Retour à la liste des rendez-vous</a>
</div>

<!-- Si au moins un RDV supprimé, on affiche le bouton pour tout supprimer définitivement -->
@if($rdvs->count() > 0)
    <div style="text-align: center; margin-top: 30px;">
        <form method="POST" action="{{ route('rdv.supprimerToutDefinitivement') }}">
            @csrf
            @method('DELETE')
            <button type="submit"
                    onclick="return confirm('Supprimer définitivement TOUS les rendez-vous supprimés ?')"
                    style="background-color: red; color: white; padding: 10px 20px; border-radius: 5px; font-weight: bold; border: none; cursor: pointer;">
                🧹 Supprimer tous les rendez-vous définitivement
            </button>
        </form>
    </div>
@endif

@endsection
