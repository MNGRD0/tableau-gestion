<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Facture PDF</title>
    <style>
        body {
            font-family: sans-serif;
            font-size: 14px;
        }
        h2 {
            text-align: center;
            margin-bottom: 30px;
        }
        .section {
            margin-bottom: 20px;
        }
        .label {
            font-weight: bold;
        }
        .box {
            border: 1px solid #ccc;
            padding: 10px;
        }
    </style>
</head>
<body>
    <h2>Facture n°{{ $facture->id }}</h2>

    <div class="section">
        <p><span class="label">Client :</span> {{ $facture->client->nom }}</p>
        <p><span class="label">Adresse :</span> {{ $facture->client->adresse_client }}, {{ $facture->client->cp_client }} {{ $facture->client->ville_client }}</p>
    </div>

    <div class="section">
        <p><span class="label">Montant :</span> {{ $facture->montant }} €</p>
        <p><span class="label">Moyen de paiement :</span> {{ $facture->moyen_paiement }}</p>
        <p><span class="label">Échelonné :</span> {{ $facture->echelonner ? 'Oui' : 'Non' }}</p>
        <p><span class="label">Statut :</span> {{ $facture->statut_facture }}</p>
    </div>

    @if($facture->commentaire_facture)
    <div class="section box">
        <span class="label">Commentaire :</span><br>
        {{ $facture->commentaire_facture }}
    </div>
    @endif

    <div style="text-align: right;">
        <small>Document généré le {{ now()->format('d/m/Y à H:i') }}</small>
    </div>
</body>
</html>
