@extends('layouts.app')

@section('content')
    <h1 style="text-align: center;">Connexion administrateur</h1>

    @if(session('succes'))
        <div style="background-color: #d4edda; color: #155724; padding: 10px; border-radius: 5px; width: 80%; margin: 20px auto; text-align: center;">
            {{ session('succes') }}
        </div>
    @endif

    @if($errors->any())
        <div style="color: red; text-align: center; margin-bottom: 20px;">
            <ul style="list-style: none;">
                @foreach($errors->all() as $erreur)
                    <li>{{ $erreur }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('admin.seConnecter') }}" style="max-width: 400px; margin: 0 auto;">
        @csrf

        <label for="nom_admin"><strong>Nom admin :</strong></label>
        <input type="text" id="nom_admin" name="nom_admin" value="{{ old('nom_admin') }}" required
               style="width: 100%; padding: 10px; margin-bottom: 15px;">

        <label for="mot_de_passe"><strong>Mot de passe :</strong></label>
        <input type="password" id="mot_de_passe" name="mot_de_passe" required
               style="width: 100%; padding: 10px; margin-bottom: 15px;">

        <div style="text-align: center;">
            <button type="submit"
                    style="padding: 10px 20px; background-color: #007bff; color: white; border: none; border-radius: 5px;">
                🔐 Connexion
            </button>
        </div>
    </form>
@endsection
