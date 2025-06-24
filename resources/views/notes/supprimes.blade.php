@extends('layouts.app')

@section('content')
    <h1 style="text-align: center;">Notes supprimées</h1>

    @if(session('succes'))
        <div style="background-color: #d4edda; color: #155724; padding: 10px; border-radius: 5px; margin: 20px auto; width: 80%; text-align: center;">
            {{ session('succes') }}
        </div>
    @endif

    <style>
        .notes-grid {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            gap: 20px;
            margin-top: 30px;
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
        @forelse ($notes as $note)
            <div class="note-card" style="background-color: {{ $note->couleur ?? '#ffff88' }};">
                <div><strong>Client :</strong>
                    @if($note->client)
                        <a href="{{ route('clients.afficher', $note->client->id) }}"
                           style="color: #007acc; text-decoration: underline; font-weight: bold;">
                           {{ $note->client->nom }}
                        </a>
                    @else
                        <span style="color: red; font-style: italic;">Client supprimé</span>
                    @endif
                </div>
                <div style="margin-top: 10px;"><strong>Contenu :</strong><br>
                    {{ \Illuminate\Support\Str::limit($note->contenu, 120, '...') }}
                </div>
                <div class="note-date">{{ $note->created_at->format('d/m/Y H:i') }}</div>

                <div class="note-actions">
                    <form method="POST" action="{{ route('notes.restaurer', $note->id) }}" style="display:inline;">
                        @csrf
                        <button type="submit" title="Restaurer" style="color: green; background: none; border: none; cursor: pointer;">🔄</button>
                    </form>

                    <form method="POST" action="{{ route('notes.supprimerDefinitivement', $note->id) }}" style="display:inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" title="Supprimer définitivement"
                                onclick="return confirm('Supprimer définitivement cette note ?')"
                                style="color: red; background: none; border: none; cursor: pointer;">🧹</button>
                    </form>
                </div>
            </div>
        @empty
            <p style="text-align: center; color: red;">Aucune note supprimée.</p>
        @endforelse
    </div>

    <div style="text-align: center; margin-top: 30px;">
        <a href="{{ route('notes.index') }}" style="text-decoration: none; font-weight: bold;">⬅️ Retour à la liste des notes</a>
    </div>

    @if($notes->count() > 0)
        <div style="text-align: center; margin-bottom: 20px;">
            <form action="{{ route('notes.supprimerToutesDefinitivement') }}" method="POST" onsubmit="return confirm('Supprimer définitivement TOUTES les notes supprimées ?')">
                @csrf
                @method('DELETE')
                <button type="submit"
                        style="padding: 10px 15px; background-color: red; color: white; border: none; border-radius: 5px; font-weight: bold; cursor: pointer; margin-top: 10px;">
                    🧹 Supprimer toutes les notes définitivement
                </button>
            </form>
        </div>
    @endif
@endsection
