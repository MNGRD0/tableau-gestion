@extends('layouts.app') 
<!-- On utilise le layout principal du site -->

@section('content')
    <h1 style="text-align: center;">Factures supprimées</h1>

    <!-- ✅ Message de succès s'il existe (après une restauration ou suppression) -->
    @if(session('succes'))
        <div style="background-color: #d4edda; color: #155724; padding: 10px; border-radius: 5px; margin: 20px auto; width: 80%; text-align: center;">
            {{ session('succes') }}
        </div>
    @endif

    <style>
        /* ✅ Style responsive pour l'affichage mobile */
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
                content: attr(data-label);
                font-weight: bold;
                color: #555;
            }

            form {
                margin-bottom: 70px;
            }
        }
    </style>

    <!-- ✅ Tableau des factures supprimées -->
    <table border="1" cellpadding="8" cellspacing="0" style="margin: 0 auto; width: 90%; margin-top: 30px;">
        <thead>
            <tr>
                <th>Client</th>
                <th>Date</th>
                <th>Montant</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
        @forelse ($factures as $facture)
            <tr>
                <td data-label="Client">
                    <!-- Vérifie si le client est encore présent -->
                    @if($facture->client)
                        {{ $facture->client->nom }}
                    @else
                        <span style="color: red;">Client supprimé</span>
                    @endif
                </td>

                <!-- Affiche la date de la facture avec Carbon -->
                <td data-label="Date">{{ \Carbon\Carbon::parse($facture->date_facture)->format('d/m/Y') }}</td>

                <!-- Affiche le montant formaté -->
                <td data-label="Montant">{{ number_format($facture->montant, 2, ',', ' ') }} €</td>

                <!-- ✅ Boutons pour restaurer ou supprimer définitivement -->
                <td data-label="Actions" style="text-align: center;">
                    <!-- Restaurer -->
                    <form method="POST" action="{{ route('factures.restaurer', $facture->id) }}" style="display:inline;">
                        @csrf
                        <button type="submit" title="Restaurer" style="color: green; background: none; border: none; cursor: pointer;">🔄</button>
                    </form>

                    <!-- Supprimer définitivement -->
                    <form method="POST" action="{{ route('factures.supprimer.definitivement', $facture->id) }}" style="display:inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" title="Supprimer définitivement"
                                onclick="return confirm('Supprimer définitivement cette facture ?')"
                                style="color: red; background: none; border: none; cursor: pointer;">🧹</button>
                    </form>
                </td>
            </tr>
        @empty
            <!-- Message si aucune facture supprimée -->
            <tr>
                <td colspan="4" style="text-align: center; color: red;">Aucune facture supprimée.</td>
            </tr>
        @endforelse
        </tbody>
    </table>

    <!-- 🔙 Lien retour -->
    <div style="text-align: center; margin-top: 30px;">
        <a href="{{ route('factures.index') }}" style="text-decoration: none; font-weight: bold;">⬅️ Retour à la liste des factures</a>
    </div>

    <!-- 🧹 Supprimer toutes les factures supprimées -->
    @if($factures->count() > 0)
        <div style="text-align: center; margin-top: 30px;">
            <form method="POST" action="{{ route('factures.supprimerToutDefinitivement') }}">
                @csrf
                @method('DELETE')
                <button type="submit"
                        onclick="return confirm('Supprimer définitivement TOUTES les factures supprimées ?')"
                        style="background-color: red; color: white; padding: 10px 20px; border-radius: 5px; font-weight: bold; border: none; cursor: pointer;">
                    🧹 Supprimer toutes les factures définitivement
                </button>
            </form>
        </div>
    @endif
@endsection
