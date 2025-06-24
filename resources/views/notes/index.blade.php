@extends('layouts.app')

@section('content')

@if(session('succes'))
    <div style="background-color: #d4edda; color: #155724; padding: 10px; border-radius: 5px; margin-bottom: 20px; text-align: center;">
        {{ session('succes') }}
    </div>
@endif

<h1 style="text-align: center;">Liste des notes</h1>

<p style="text-align: center;">Nombre de notes : {{ $notes->count() }}</p>

<div style="margin-bottom: 20px; text-align: right;">
    <a href="{{ route('notes.creer') }}"
       style="padding: 10px 15px; background-color: rgb(22, 201, 22); color: white; text-decoration: none; border-radius: 5px; font-weight: bold;">
        + Ajouter une note
    </a>
</div>

<style>
    .notes-grid {
        display: flex;
        flex-wrap: wrap;
        justify-content: center;
        gap: 20px;
    }

    .note-card {
        width: 250px;
        min-height: 150px;
        padding: 15px;
        border-radius: 10px;
        color: #333;
        box-shadow: 0 3px 6px rgba(0,0,0,0.1);
        position: relative;
        word-wrap: break-word;
    }

    .note-actions {
        position: absolute;
        bottom: 10px;
        right: 10px;
        text-align: right;
    }

    .note-date {
        font-size: 12px;
        color: #555;
        margin-top: 10px;
    }

    @media screen and (max-width: 768px) {
        .note-card {
            width: 90%;
        }

        form {
            margin-bottom: 70px;
        }
    }
</style>

<div class="notes-grid">
    
    @forelse($notes as $note)
        <div class="note-card" style="background-color: {{ $note->couleur ?? '#ffff88' }}; margin-top : 30px;">
            <div><strong>Client :</strong>
                <a href="{{ route('clients.afficher', $note->client->id) }}"
                   style="color: #007acc; text-decoration: underline; font-weight: bold;">
                   {{ $note->client->nom }}
                </a>
            </div>

            <div style="margin-top: 10px;"><strong>Contenu :</strong><br>
                {{ \Illuminate\Support\Str::limit($note->contenu, 120, '...') }}
            </div>

            <div class="note-date">{{ $note->created_at->format('d/m/Y H:i') }}</div>

            <div class="note-actions">
                <a href="{{ route('notes.afficher', $note->id) }}" title="Afficher" style="color: green; margin: 0 3px;">👁️</a>
                <a href="{{ route('notes.modifier', $note->id) }}" title="Modifier" style="color: orange; margin: 0 3px;">✏️</a>
                <form action="{{ route('notes.supprimer', $note->id) }}" method="POST" style="display:inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" title="Supprimer"
                            onclick="return confirm('Supprimer cette note ?')"
                            style="color: red; background: none; border: none; font-size: 16px; cursor: pointer;">
                        ➖
                    </button>
                </form>
            </div>
        </div>
    @empty
        <p style="text-align: center; color: red;">Aucune note trouvée.</p>
    @endforelse
</div>

@if($notes->count() > 10)
    <div style="text-align: center; margin-top: 20px;">
        @if(request()->get('mode') === 'tout')
            <a href="{{ route('notes.index') }}"
               style="color: #007bff; text-decoration: underline; font-weight: bold;">
                🔙 Réduire la liste
            </a>
        @else
            <a href="{{ route('notes.index', ['mode' => 'tout']) }}"
               style="color: #007bff; text-decoration: underline; font-weight: bold;">
                ➕ Afficher toutes les notes
            </a>
        @endif
    </div>
@endif

@if($notes->count() >= 0)
    <div style="text-align: center; margin-top: 20px;">
        <a href="{{ route('notes.supprimes') }}" style="text-decoration: none; color: red; font-weight: bold;">
            🗑️ Voir les notes supprimées
        </a>
    </div>
@endif

@endsection
