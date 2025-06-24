@extends('layouts.app')

@section('content')
    <h1 style="text-align: center;">Rendez-vous supprimés</h1>

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
                <td data-label="Client">{{ $rdv->nom_client }}</td>
                <td data-label="Date">{{ $rdv->date }}</td>
                <td data-label="Lieu">{{ $rdv->lieu }}</td>
                <td data-label="Statut">{{ $rdv->statut_rdv }}</td>
                <td data-label="Actions" style="text-align: center;">
                    <form method="POST" action="{{ route('rdv.restaurer', $rdv->id) }}" style="display:inline;">
                        @csrf
                        <button type="submit" title="Restaurer" style="color: green; background: none; border: none; cursor: pointer;">🔄</button>
                    </form>

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
            <tr>
                <td colspan="5" style="text-align: center; color: red;">Aucun rendez-vous supprimé.</td>
            </tr>
        @endforelse
        </tbody>
    </table>

    <div style="text-align: center; margin-top: 30px;">
        <a href="{{ route('rdv.index') }}" style="text-decoration: none; font-weight: bold;">⬅️ Retour à la liste des rendez-vous</a>
    </div>

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