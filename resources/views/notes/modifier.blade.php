@extends('layouts.app')

@section('content')
    <h1 style="text-align: center;">Modifier la note</h1>

    @if ($errors->any())
        <div style="background-color: #f8d7da; color: #721c24; padding: 10px; border-radius: 5px; margin: 20px auto; width: 80%; text-align: center;">
            @foreach ($errors->all() as $error)
                <p>{{ $error }}</p>
            @endforeach
        </div>
    @endif

    <form method="POST" action="{{ route('notes.mettreAJour', $note->id) }}" style="max-width: 600px; margin: 0 auto;">
        @csrf
        @method('PUT')

        <div style="margin-bottom: 20px;">
            <label for="client_id" style="font-weight: bold;">Client :</label>
            <select name="client_id" id="client_id" required style="width: 100%; padding: 8px;">
                <option value="">-- Choisir un client --</option>
                @foreach ($clients as $client)
                    <option value="{{ $client->id }}" {{ $note->client_id == $client->id ? 'selected' : '' }}>
                        {{ $client->nom }}
                    </option>
                @endforeach
            </select>
        </div>

        <div style="margin-bottom: 20px;">
            <label for="contenu" style="font-weight: bold;">Contenu :</label>
            <textarea name="contenu" id="contenu" rows="5" required
                      style="width: 100%; padding: 10px;">{{ old('contenu', $note->contenu) }}</textarea>
        </div>

        <div style="margin-bottom: 20px;">
            <label for="couleur" style="font-weight: bold;">Couleur :</label>
            <input type="color" name="couleur" id="couleur" value="{{ old('couleur', $note->couleur ?? '#ffff88') }}"
                   style="width: 100%; height: 40px; border: none; padding: 0;">
        </div>

        <div style="text-align: center;">
            <button type="submit"
                    style="padding: 10px 20px; background-color: #007bff; color: white; border: none; border-radius: 5px; font-weight: bold; cursor: pointer;">
                💾 Enregistrer les modifications
            </button>
        </div>
    </form>

    <div style="text-align: center; margin-top: 20px;">
        <a href="{{ route('notes.index') }}" style="text-decoration: none; font-weight: bold;">
            ⬅️ Retour à la liste des notes
        </a>
    </div>
@endsection
