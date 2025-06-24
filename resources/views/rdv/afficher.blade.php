@extends('layouts.app')

@section('content')
<h1 style="text-align: center;">Détails du rendez-vous</h1>

<div style="max-width: 600px; margin: 30px auto; background: #f5faff; padding: 20px; border-radius: 8px; box-shadow: 0 0 10px rgba(0,0,0,0.1);">
<p>
    <strong style="color: #007acc;">Client :</strong> 
    <a href="{{ route('clients.afficher', $rdv->client->id) }}" 
       style="color: #007acc; font-weight: bold; text-decoration: underline;">
        {{ $rdv->client->nom }}
    </a>
</p>

    <p><strong style="color: #007acc;">Date :</strong> {{ \Carbon\Carbon::parse($rdv->date)->format('d/m/Y à H\hi') }}</p>
    <p><strong style="color: #007acc;">Lieu :</strong> {{ $rdv->lieu }}</p>
    <p><strong style="color: #007acc;">Statut :</strong> {{ ucfirst($rdv->statut_rdv) }}</p>
    <p><strong style="color: #007acc;">Commentaire :</strong> {{ $rdv->commentaire_rdv ?? '—' }}</p>
</div>

<div style="text-align: center; margin: 20px auto; max-width: 600px;">
    <a href="{{ route('rdv.index') }}"
       style="text-decoration: none; color: white; background-color: #007acc; padding: 10px 15px; border-radius: 5px; font-weight: bold;">
        ⬅️ Retour à la liste
    </a>
</div>
@endsection
