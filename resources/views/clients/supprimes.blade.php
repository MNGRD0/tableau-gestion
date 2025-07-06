@extends('layouts.app')
<!-- On utilise le layout général commun à toutes les pages -->

@section('content')
<main> <!-- ✅ Ajout pour l'accessibilité : indique le contenu principal de la page -->

    <h1 style="text-align: center;">Clients supprimés</h1>

    @if(session('succes'))
        <!-- Si un message "succes" existe dans la session, on l'affiche ici -->
        <div style="background-color: #d4edda; color: #155724; padding: 10px; border-radius: 5px; margin: 20px auto; width: 80%; text-align: center;">
            {{ session('succes') }}
        </div>
    @endif

    <!-- CSS Responsive (pour téléphone) -->
    <style>
        @media screen and (max-width: 768px) {
            table {
                width: 100%;
                display: block;
                overflow-x: auto;
                white-space: nowrap;
            }

            table thead {
                display: none; /* On cache l'en-tête sur petit écran */
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
                content: attr(data-label); /* Affiche le nom de la colonne devant les données */
                font-weight: bold;
                color: #555;
            }

            form {
                margin-bottom: 70px;
            }
        }
    </style>

    <!-- Tableau des clients supprimés -->
    <table border="1" cellpadding="8" cellspacing="0" style="margin: 0 auto; width: 90%; margin-top: 30px;">
        <thead>
            <tr>
                <th>Nom</th>
                <th>Email</th>
                <th>Ville</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
        @forelse ($clients as $client)
            <!-- On affiche chaque client supprimé -->
            <tr>
                <td data-label="Nom">{{ $client->nom }}</td>
                <td data-label="Email">{{ $client->email_client }}</td>
                <td data-label="Ville">{{ $client->ville_client }}</td>
                <td data-label="Actions" style="text-align: center;">
                    
                    <!-- Formulaire pour restaurer ce client -->
                    <form method="POST" action="{{ route('clients.restaurer', $client->id) }}" style="display:inline;">
                        @csrf <!-- Protection contre les fausses requêtes -->
                        <button type="submit" title="Restaurer"
                                style="color: green; background: none; border: none; cursor: pointer;">
                            🔄
                        </button>
                    </form>

                    <!-- Formulaire pour supprimer ce client définitivement -->
                    <form method="POST" action="{{ route('clients.supprimer.definitivement', $client->id) }}" style="display:inline;">
                        @csrf
                        @method('DELETE') <!-- On simule une requête DELETE -->
                        <button type="submit" title="Supprimer définitivement"
                                onclick="return confirm('Supprimer définitivement ce client ?')"
                                style="color: red; background: none; border: none; cursor: pointer;">
                            🧹
                        </button>
                    </form>
                </td>
            </tr>
        @empty
            <!-- S’il n’y a aucun client supprimé -->
            <tr>
                <td colspan="4" style="text-align: center; color: red;">Aucun client supprimé.</td>
            </tr>
        @endforelse
        </tbody>
    </table>

    <!-- Lien de retour vers la liste normale des clients -->
    <div style="text-align: center; margin-top: 30px;">
        <a href="{{ route('clients.index') }}" style="text-decoration: none; font-weight: bold;">
            ⬅️ Retour à la liste des clients
        </a>
    </div>

    @if($clients->count() > 0)
        <!-- Formulaire pour supprimer tous les clients supprimés en une fois -->
        <div style="text-align: center; margin-top: 30px;">
            <form method="POST" action="{{ route('clients.supprimerToutDefinitivement') }}">
                @csrf
                @method('DELETE')
                <button type="submit"
                        onclick="return confirm('Supprimer définitivement TOUS les clients supprimés ?')"
                        style="background-color: red; color: white; padding: 10px 20px; border-radius: 5px; font-weight: bold; border: none; cursor: pointer;">
                    🧹 Supprimer tous les clients définitivement
                </button>
            </form>
        </div>
    @endif

</main>
@endsection
