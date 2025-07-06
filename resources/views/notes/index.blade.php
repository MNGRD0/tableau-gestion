@extends('layouts.app')
<!-- On utilise le layout principal du site (layouts/app.blade.php) -->

@section('content')
<!-- Début du contenu spécifique à cette page -->

    <h1 style="text-align: center;">Liste des notes</h1>

    <!-- Affiche un message de succès si une note a été ajoutée ou supprimée -->
    @if(session('succes'))
        <div style="background-color: #d4edda; color: #155724; padding: 10px; border-radius: 5px; margin-bottom: 20px; text-align: center;">
            {{ session('succes') }}
        </div>
    @endif

    <!-- Affiche le nombre total de notes -->
    <p style="text-align: center;">Nombre de notes : {{ $notes->count() }}</p>

    <!-- Bouton pour ajouter une nouvelle note -->
    <div style="margin-bottom: 20px; text-align: right;">
        <a href="{{ route('notes.creer') }}"
           style="padding: 10px 15px; background-color: rgb(22, 201, 22); color: white; text-decoration: none; border-radius: 5px; font-weight: bold;">
            + Ajouter une note
        </a>
    </div>

    <style>
        /* Style des notes affichées en grille (type post-it) */
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

    <!-- Affichage des notes sous forme de cartes colorées -->
    <div class="notes-grid">
        
        @forelse($notes as $note)
            <div class="note-card" style="background-color: {{ $note->couleur ?? '#ffff88' }}; margin-top : 30px;">
                
                <!-- Affiche le nom du client associé à la note (avec lien vers sa fiche) -->
                <div><strong>Client :</strong>
                    <a href="{{ route('clients.afficher', $note->client->id) }}"
                       style="color: #007acc; text-decoration: underline; font-weight: bold;">
                       {{ $note->client->nom }}
                    </a>
                </div>

                <!-- Contenu de la note limité à 120 caractères -->
                <div style="margin-top: 10px;"><strong>Contenu :</strong><br>
                    {{ \Illuminate\Support\Str::limit($note->contenu, 120, '...') }}
                </div>

                <!-- Date de création de la note -->
                <div class="note-date">{{ $note->created_at->format('d/m/Y H:i') }}</div>

                <!-- Boutons d'action : afficher / modifier / supprimer -->
                <div class="note-actions">
                    <!-- 👁️ Afficher la note -->
                    <a href="{{ route('notes.afficher', $note->id) }}" title="Afficher" style="color: green; margin: 0 3px;">👁️</a>
                    
                    <!-- ✏️ Modifier la note -->
                    <a href="{{ route('notes.modifier', $note->id) }}" title="Modifier" style="color: orange; margin: 0 3px;">✏️</a>

                    <!-- 🗑️ Supprimer la note (suppression logique) -->
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
            <!-- Message si aucune note n’est trouvée -->
            <p style="text-align: center; color: red;">Aucune note trouvée.</p>
        @endforelse
    </div>

    <!-- Si on a plus de 10 notes, proposer de toutes les afficher ou de réduire la liste -->
    @if($notes->count() > 10)
        <div style="text-align: center; margin-top: 20px;">
            @if(request()->get('mode') === 'tout')
                <!-- Si on est en mode "tout", proposer de revenir à la liste réduite -->
                <a href="{{ route('notes.index') }}"
                   style="color: #007bff; text-decoration: underline; font-weight: bold;">
                    🔙 Réduire la liste
                </a>
            @else
                <!-- Sinon, proposer d’afficher toutes les notes -->
                <a href="{{ route('notes.index', ['mode' => 'tout']) }}"
                   style="color: #007bff; text-decoration: underline; font-weight: bold;">
                    ➕ Afficher toutes les notes
                </a>
            @endif
        </div>
    @endif

    <!-- Lien vers la page des notes supprimées -->
    @if($notes->count() >= 0)
        <div style="text-align: center; margin-top: 20px;">
            <a href="{{ route('notes.supprimes') }}" style="text-decoration: none; color: red; font-weight: bold;">
                🗑️ Voir les notes supprimées
            </a>
        </div>
    @endif

@endsection
