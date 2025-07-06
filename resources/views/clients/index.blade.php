@extends('layouts.app')

@php use Illuminate\Support\Str; @endphp

@section('content')

{{-- Si un message "succes" est présent dans la session, on l'affiche dans un encadré vert --}}
@if(session('succes'))
    <div style="background-color: #d4edda; color: #155724; padding: 10px; border-radius: 5px; margin-bottom: 20px; text-align: center;">
        {{ session('succes') }}
    </div>
@endif

<h1 style="text-align: center;">Liste des clients</h1>

{{-- Affiche le nombre total de clients --}}
<p>Nombre de clients : {{ $clients->count() }}</p>

{{-- Formulaire de tri : on sélectionne et ça recharge la page automatiquement --}}
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

{{-- Bouton pour ajouter un nouveau client --}}
<div style="margin-bottom: 20px; text-align: right; margin-top: -30px;">
    <a href="{{ route('clients.creer') }}" class="ajouterBtn"
       style="padding: 10px 15px; background-color: rgb(22, 201, 22); color: white; text-decoration: none; border-radius: 5px; font-weight: bold; cursor: pointer;">
        + Ajouter un client
    </a>
</div>

{{-- Contenu principal de la page --}}
<main>
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
                {{-- Chaque cellule a un data-label pour les lecteurs d'écran et pour l'affichage mobile --}}
                <td data-label="Nom">{{ $client->nom }}</td>
                <td data-label="Téléphone">{{ $client->telephone_client }}</td>
                <td data-label="Email">{{ $client->email_client }}</td>
                <td data-label="Adresse">{{ Str::limit($client->adresse_client, 19, '...') }}</td>
                <td data-label="Code postal">{{ $client->cp_client }}</td>
                <td data-label="Ville">{{ Str::limit($client->ville_client, 9, '...') }}</td>
                <td data-label="Actions" style="text-align: center;">
                    {{-- Icône pour afficher le client --}}
                    <a href="{{ route('clients.afficher', $client->id) }}" title="Afficher"
                       style="color: green; font-size: 16px; margin: 0 5px; text-decoration: none;">👁️</a>
                    <span style="color: #ccc;">|</span>
                    {{-- Icône pour modifier le client --}}
                    <a href="{{ route('clients.modifier', $client->id) }}" title="Modifier"
                       style="color: orange; font-size: 16px; margin: 0 5px; text-decoration: none;">✏️</a>
                    <span style="color: #ccc;">|</span>
                    {{-- Formulaire pour supprimer un client (avec protection CSRF) --}}
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
</main>

{{-- Lien pour afficher ou réduire toute la liste s'il y a plus de 10 clients --}}
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

{{-- Lien pour aller à la corbeille (clients supprimés) --}}
@if($clients->count() >= 0)
    <div style="text-align: center; margin-top: 20px;">
    <a href="{{ route('clients.supprimes') }}" style="text-decoration: none; color: red; font-weight: bold;">
        🗑️ Voir les clients supprimés
    </a>
    </div>
@endif
@endsection
