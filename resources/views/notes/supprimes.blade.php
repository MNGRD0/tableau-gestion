@extends('layouts.app')
<!-- On hérite du layout principal situé dans resources/views/layouts/app.blade.php -->

@section('content')
<!-- Début du contenu spécifique à cette vue -->

    <h1 style="text-align: center;">Notes supprimées</h1>

    <!-- Message de succès s'il existe dans la session -->
    @if(session('succes'))
        <div style="background-color: #d4edda; color: #155724; padding: 10px; border-radius: 5px; margin: 20px auto; width: 80%; text-align: center;">
            {{ session('succes') }}
        </div>
    @endif

    <style>
        /* Grille pour afficher les notes sous forme de post-it */
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

        /* Adaptation mobile */
        @media screen and (max-width: 768px) {
            .note-card {
                width: 90%;
            }

            form {
                margin-bottom: 70px;
            }
        }
    </style>

    <!-- Affichage des notes supprimées sous forme de cartes colorées -->
    <div class="notes-grid">
        @forelse ($notes as $note)
            <div class="note-card" style="background-color: {{ $note->couleur ?? '#ffff88' }};">
                <!-- ✅ Nom du client associé à la note -->
                <div><strong>Client :</strong>
                    @if($note->client)
                        <!-- Si le client existe, on affiche son nom avec un lien vers sa fiche -->
                        <a href="{{ route('clients.afficher', $note->client->id) }}"
                           style="color: #007acc; text-decoration: underline; font-weight: bold;">
                           {{ $note->client->nom }}
                        </a>
                    @else
                        <!-- Sinon on affiche une info précisant qu’il a été supprimé -->
                        <span style="color: red; font-style: italic;">Client supprimé</span>
                    @endif
                </div>

                <!-- ✅ Contenu de la note, limité à 120 caractères -->
                <div style="margin-top: 10px;"><strong>Contenu :</strong><br>
                    {{ \Illuminate\Support\Str::limit($note->contenu, 120, '...') }}
                </div>

                <!-- ✅ Date de création de la note formatée (grâce à Carbon) -->
                <div class="note-date">{{ $note->created_at->format('d/m/Y H:i') }}</div>

                <!-- ✅ Actions sur la note : restaurer ou supprimer définitivement -->
                <div class="note-actions">
                    <!-- Restaurer la note -->
                    <form method="POST" action="{{ route('notes.restaurer', $note->id) }}" style="display:inline;">
                        @csrf
                        <button type="submit" title="Restaurer" style="color: green; background: none; border: none; cursor: pointer;">🔄</button>
                    </form>

                    <!-- Supprimer définitivement la note -->
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
            <!-- S’il n’y a aucune note supprimée -->
            <p style="text-align: center; color: red;">Aucune note supprimée.</p>
        @endforelse
    </div>

    <!-- ✅ Lien retour vers les notes actives -->
    <div style="text-align: center; margin-top: 30px;">
        <a href="{{ route('notes.index') }}" style="text-decoration: none; font-weight: bold;">
            ⬅️ Retour à la liste des notes
        </a>
    </div>

    <!-- ✅ Bouton pour tout supprimer définitivement si des notes supprimées existent -->
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
