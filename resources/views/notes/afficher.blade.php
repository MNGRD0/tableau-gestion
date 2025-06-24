@extends('layouts.app')

@section('content')
    <h1 style="text-align: center;">Détail de la note</h1>

    <div style="max-width: 600px; margin: 30px auto; background-color: white; border-radius: 8px; padding: 25px; box-shadow: 0 0 10px rgba(0,0,0,0.1);">
        <p><strong>Client :</strong>
            <a href="{{ route('clients.afficher', $note->client->id) }}" style="text-decoration: underline; font-weight: bold;">
                {{ $note->client->nom }}
            </a>
        </p>
        <p><strong>Contenu :</strong> {{ $note->contenu }}</p>
        <p><strong>Date :</strong> {{ $note->created_at->format('d/m/Y H:i') }}</p>
    </div>

    <div style="text-align: center;">
        <a href="{{ route('notes.index') }}" style="text-decoration: none; font-weight: bold;">
            ⬅️ Retour à la liste
        </a>
    </div>
@endsection
