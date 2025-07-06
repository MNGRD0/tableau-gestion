@extends('layouts.app')
<!-- On utilise le layout général du site (fichier resources/views/layouts/app.blade.php) -->

@section('content')
<!-- On ouvre la section "content" qui s’insère dans @yield('content') du layout -->

<main> <!-- ✅ Ajouté pour l’accessibilité : balise HTML5 qui indique le contenu principal de la page -->

<div class="container" style="max-width: 900px; margin: auto; padding: 30px 20px;">

    <!-- TITRE -->
    <h2 style="text-align: center; margin-bottom: 10px;">🎉 Mon espace client</h2>

    <!-- Message personnalisé de bienvenue -->
    <p style="text-align: center; font-size: 1.1em; margin-bottom: 30px;">
        Bienvenue <strong>{{ $client->nom }}</strong> !
        <!-- On affiche ici le nom du client connecté -->
    </p>

    <!-- REMARQUE DE L’ADMINISTRATEUR -->
    @if($client->commentaire_client)
        <!-- Si un commentaire a été ajouté à ce client, on l'affiche dans une boîte jaune -->
        <div style="margin-bottom: 30px; padding: 15px; background-color: #fff3cd; border-left: 5px solid #ffeeba; border-radius: 8px;">
            <strong>📢 Remarque de l’administrateur :</strong><br>
            {{ $client->commentaire_client }}
        </div>
    @endif

    <!-- PROFIL DU CLIENT -->
    <div style="margin-bottom: 50px; padding: 20px; background: #f9fafb; border-radius: 10px; border: 1px solid #ddd;">
        <h3 style="color: #2d3748; margin-bottom: 15px;">👤 Mon profil</h3>

        <!-- Données personnelles -->
        <p><strong>Nom :</strong> {{ $client->nom }}</p>
        <p><strong>Email :</strong> {{ $client->email_client }}</p>
        <p><strong>Téléphone :</strong> {{ $client->telephone_client }}</p>
        <p><strong>Adresse :</strong> {{ $client->adresse_client }}, {{ $client->cp_client }} {{ $client->ville_client }}</p>

        <!-- Bouton pour modifier ses infos -->
        <div style="text-align: right; margin-top: 15px;">
            <a href="{{ route('client.profil.modifier') }}" style="padding: 8px 14px; background-color: #3490dc; color: white; border-radius: 5px; text-decoration: none; font-weight: bold;">
                ✏️ Modifier mes informations
            </a>
        </div>
    </div>

    <!-- FACTURES DU CLIENT -->
    <div style="margin-bottom: 50px; padding: 20px; background: #f0f4f8; border-radius: 10px;">
        <h3 style="color: #2d3748; margin-bottom: 15px;">📄 Mes factures</h3>

        @if($factures->isEmpty())
            <!-- Si aucune facture n’est liée à ce client -->
            <p style="color: #555;">Vous n'avez aucune facture.</p>
        @else
            <!-- Sinon, on affiche un tableau de factures -->
            <table style="width: 100%; border-collapse: collapse;">
                <thead>
                    <tr>
                        <th style="padding: 10px; border-bottom: 1px solid #ccc; text-align: left;">Numéro</th>
                        <th style="padding: 10px; border-bottom: 1px solid #ccc; text-align: right;">Montant</th>
                        <th style="padding: 10px; border-bottom: 1px solid #ccc; text-align: center;">Date</th>
                        <th style="padding: 10px; border-bottom: 1px solid #ccc; text-align: center;">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($factures as $facture)
                        <tr>
                            <!-- Numéro de facture -->
                            <td style="padding: 10px; text-align: left;">{{ $facture->numero }}</td>

                            <!-- Montant formaté avec virgule et espace -->
                            <td style="padding: 10px; text-align: right;">
                                {{ number_format($facture->montant, 2, ',', ' ') }} €
                            </td>

                            <!-- Date au format français -->
                            <td style="padding: 10px; text-align: center;">
                                {{ $facture->created_at->format('d/m/Y') }}
                            </td>

                            <!-- Bouton de téléchargement en PDF -->
                            <td style="padding: 10px; text-align: center;">
                                <a href="{{ route('client.facture.pdf', $facture->id) }}"
                                   style="background-color: #38b2ac; padding: 6px 10px; border-radius: 5px; color: white; font-weight: bold; text-decoration: none;">
                                    📥 Télécharger PDF
                                </a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endif
    </div>

    <!-- RENDEZ-VOUS DU CLIENT -->
    <div style="margin-bottom: 50px; padding: 20px; background: #f7f7fb; border-radius: 10px;">
        <h3 style="color: #2d3748; margin-bottom: 15px;">📆 Mes rendez-vous</h3>

        @if($rdvs->isEmpty())
            <!-- Si aucun RDV -->
            <p style="color: #555;">Vous n'avez aucun rendez-vous.</p>
        @else
            <!-- Liste des RDVs -->
            <ul style="list-style-type: none; padding: 0;">
                @foreach($rdvs as $rdv)
                    <li style="margin-bottom: 15px; border-bottom: 1px solid #eee; padding-bottom: 10px;">
                        
                        <!-- Date du rendez-vous 
                         « Prends la date du rendez-vous, transforme-la en format date (jour/mois/année heure:minute), puis affiche-la. »-->
                        <strong>{{ \Carbon\Carbon::parse($rdv->date)->format('d/m/Y H:i') }}</strong> à {{ $rdv->lieu }}<br>

                        <!-- Statut : à venir, en cours, ou passé -->
                        <span style="font-size: 0.9em; color: #555;">Statut : {{ $rdv->statut_rdv }}</span>

                        <!-- Commentaire éventuel -->
                        @if($rdv->commentaire_rdv)
                            <div style="font-size: 0.85em; margin-top: 5px; color: #666;">
                                📝 {{ $rdv->commentaire_rdv }}
                            </div>
                        @endif
                    </li>
                @endforeach
            </ul>
        @endif
    </div>

    <!-- FORMULAIRE DE DÉCONNEXION -->
    <div style="text-align: center;">
        <form action="{{ route('client.deconnexion') }}" method="POST" style="display: inline;">
            @csrf <!-- Jeton de sécurité obligatoire -->
            <button type="submit"
                    style="padding: 10px 20px; background-color: #e3342f; color: white; border: none; border-radius: 5px; cursor: pointer; font-weight: bold;">
                🚪 Se déconnecter
            </button>
        </form>
    </div>

</div>
</main>
@endsection
