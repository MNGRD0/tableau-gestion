@extends('layouts.app')

@php use Illuminate\Support\Str; @endphp

@section('content')

@if(session('succes'))
    <div style="background-color: #d4edda; color: #155724; padding: 10px; border-radius: 5px; margin-bottom: 20px; text-align: center;">
        {{ session('succes') }}
    </div>
@endif

<h1 style="text-align: center;">Liste des clients</h1>

<p>Nombre de clients : {{ $clients->count() }}</p>

<form method="GET" action="{{ route('clients.index') }}">
    <label for="tri">Trier les clients :</label>
    <select name="tri" id="tri" onchange="this.form.submit()">
        <option value="">-- Choisir --</option>
        <option value="a_z" {{ $tri === 'a_z' ? 'selected' : '' }}>Nom A → Z</option>
        <option value="z_a" {{ $tri === 'z_a' ? 'selected' : '' }}>Nom Z → A</option>
        <option value="recent" {{ $tri === 'recent' ? 'selected' : '' }}>Ajouté récemment</option>
        <option value="ancien" {{ $tri === 'ancien' ? 'selected' : '' }}>Ajouté il y a longtemps</option>
    </select>
</form>

<div style="margin-bottom: 20px; text-align: right; margin-top: -30px;">
    <a href="{{ route('clients.creer') }}" class="ajouterBtn"
       style="padding: 10px 15px; background-color: rgb(22, 201, 22); color: white; text-decoration: none; border-radius: 5px; font-weight: bold; cursor: pointer;">
        + Ajouter un client
    </a>
</div>

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
            content: attr(data-label);
            font-weight: bold;
            color: #555;
        }

        form {
            margin-bottom: 70px;
        }
    }
</style>

<table border="1" cellpadding="8" cellspacing="0" style="margin: 0 auto; width: 90%; margin-top: 50px;">
    <thead>
        <tr>
            <th>Nom</th>
            <th>Téléphone</th>
            <th>Email</th>
            <th>Adresse</th>
            <th>Code postal</th>
            <th>Ville</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
    @forelse ($clients as $client)
        <tr>
            <td data-label="Nom">{{ $client->nom }}</td>
            <td data-label="Téléphone">{{ $client->telephone_client }}</td>
            <td data-label="Email">{{ $client->email_client }}</td>
            <td data-label="Adresse">{{ Str::limit($client->adresse_client, 19, '...') }}</td>
            <td data-label="Code postal">{{ $client->cp_client }}</td>
            <td data-label="Ville">{{ Str::limit($client->ville_client, 9, '...') }}</td>
            <td data-label="Actions" style="text-align: center;">
                <a href="{{ route('clients.afficher', $client->id) }}" title="Afficher"
                   style="color: green; font-size: 16px; margin: 0 5px; text-decoration: none;">👁️</a>
                <span style="color: #ccc;">|</span>
                <a href="{{ route('clients.modifier', $client->id) }}" title="Modifier"
                   style="color: orange; font-size: 16px; margin: 0 5px; text-decoration: none;">✏️</a>
                <span style="color: #ccc;">|</span>
                <form action="{{ route('clients.supprimer', $client->id) }}" method="POST" style="display:inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" title="Supprimer"
                            onclick="return confirm('Supprimer ce client ?')"
                            style="color: red; background: none; border: none; font-size: 16px; cursor: pointer; text-decoration: none;">
                        ➖
                    
                    </button>
                </form>
            </td>
        </tr>
    @empty
        <tr>
            <td colspan="8">Aucun client trouvé.</td>
        </tr>
    @endforelse
    </tbody>
</table>

@if($clients->count() > 10)
    <div style="text-align: center; margin-top: 20px;">
        @if($mode === 'tout')
            <a href="{{ route('clients.index') }}"
               style="color: #007bff; text-decoration: underline; font-weight: bold;">
                🔙 Réduire la liste
            </a>
        @else
            <a href="{{ route('clients.index', ['tri' => $tri, 'mode' => 'tout']) }}"
               style="color: #007bff; text-decoration: underline; font-weight: bold;">
                ➕ Afficher tous les clients
            </a>
        @endif
    </div>
@endif

@if($clients->count() >= 0)
    <div style="text-align: center; margin-top: 20px;">
    <a href="{{ route('clients.supprimes') }}" style="text-decoration: none; color: red; font-weight: bold;">
        🗑️ Voir les clients supprimés
    </a>
</div>

@endif

@endsection
