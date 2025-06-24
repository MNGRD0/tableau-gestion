@extends('layouts.app')

@section('content')
    <h1 style="text-align: center;">Clients supprimés</h1>

    @if(session('succes'))
        <div style="background-color: #d4edda; color: #155724; padding: 10px; border-radius: 5px; margin: 20px auto; width: 80%; text-align: center;">
            {{ session('succes') }}
        </div>
    @endif

    <style>
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
            <tr>
                <td data-label="Nom">{{ $client->nom }}</td>
                <td data-label="Email">{{ $client->email_client }}</td>
                <td data-label="Ville">{{ $client->ville_client }}</td>
                <td data-label="Actions" style="text-align: center;">
                    <form method="POST" action="{{ route('clients.restaurer', $client->id) }}" style="display:inline;">
                        @csrf
                        <button type="submit" title="Restaurer" style="color: green; background: none; border: none; cursor: pointer;">🔄</button>
                    </form>

                    <form method="POST" action="{{ route('clients.supprimer.definitivement', $client->id) }}" style="display:inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" title="Supprimer définitivement" onclick="return confirm('Supprimer définitivement ce client ?')" style="color: red; background: none; border: none; cursor: pointer;">🧹</button>
                    </form>
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="4" style="text-align: center; color: red;">Aucun client supprimé.</td>
            </tr>
        @endforelse
        </tbody>
    </table>

    <div style="text-align: center; margin-top: 30px;">
        <a href="{{ route('clients.index') }}" style="text-decoration: none; font-weight: bold;">⬅️ Retour à la liste des clients</a>
    </div>

    @if($clients->count() > 0)
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
@endsection