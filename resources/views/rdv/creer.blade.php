@extends('layouts.app')

@section('content')
<h1 style="text-align: center;">Ajouter un rendez-vous</h1>

@if ($errors->any())
    <div style="background-color: #f8d7da; color: #721c24; padding: 10px; border-radius: 5px; margin-bottom: 20px;">
        <ul style="margin: 0; padding-left: 20px;">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<form method="POST" action="{{ route('rdv.enregistrer') }}" style="max-width: 600px; margin: 0 auto;">
    @csrf

    <div style="margin-bottom: 15px;">
        <label for="client_id">Client :</label><br>
        <select name="client_id" id="client_id" required style="width: 100%; padding: 8px;">
            <option value="">-- Sélectionner un client --</option>
            @foreach($clients as $client)
                <option value="{{ $client->id }}">{{ $client->nom }}</option>
            @endforeach
        </select>
    </div>

    <div style="margin-bottom: 15px;">
        <label for="date">Date et heure :</label><br>
        <input type="datetime-local" name="date" id="date" required style="width: 100%; padding: 8px;">
    </div>

    <div style="margin-bottom: 15px;">
        <label for="lieu">Lieu :</label><br>
        <input type="text" name="lieu" id="lieu" required style="width: 100%; padding: 8px;">
    </div>

    <div style="margin-bottom: 15px;">
        <label for="statut_rdv">Statut :</label><br>
        <select name="statut_rdv" id="statut_rdv" required style="width: 100%; padding: 8px;">
            <option value="à venir">À venir</option>
            <option value="en cours">En cours</option>
            <option value="passé">Passé</option>
        </select>
    </div>

    <div style="margin-bottom: 15px;">
        <label for="commentaire_rdv">Commentaire :</label><br>
        <textarea name="commentaire_rdv" id="commentaire_rdv" rows="4" style="width: 100%; padding: 8px;"></textarea>
    </div>

    <div style="text-align: right;">
        <button type="submit" style="padding: 10px 15px; background-color: rgb(22, 201, 22); color: white; border: none; border-radius: 5px; font-weight: bold; cursor: pointer;">
            ➕ Ajouter
        </button>
    </div>
</form>
@endsection
