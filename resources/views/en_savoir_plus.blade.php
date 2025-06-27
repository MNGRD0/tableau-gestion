<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>En savoir plus</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            margin: 0;
            background: linear-gradient(to bottom right, #dff6fd, #f9fcff);
            color: #333;
        }

        .container {
            max-width: 1000px;
            margin: 60px auto;
            background-color: white;
            padding: 50px;
            border-radius: 20px;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.15);
        }

        .header {
            display: flex;
            align-items: center;
            gap: 30px;
            margin-bottom: 30px;
        }

        .header img {
            width: 150px;
            height: auto;
        }

        h1 {
            font-size: 2.5em;
            color: #007BBD;
            margin-bottom: 10px;
        }

        .text {
            font-size: 1.15em;
            line-height: 1.7;
            margin-bottom: 30px;
        }

        .section {
            background-color: #f1fbff;
            padding: 20px;
            border-radius: 12px;
            margin-bottom: 30px;
            border-left: 6px solid #00aaff;
        }

        .section h2 {
            color: #007BBD;
            margin-top: 0;
        }

        .retour {
            text-align: center;
        }

        .retour a {
            text-decoration: none;
            background-color: #007BBD;
            color: white;
            padding: 12px 25px;
            border-radius: 10px;
            font-size: 1.1em;
        }

        .retour a:hover {
            background-color: #005f87;
        }

        @media (max-width: 768px) {
            .header {
                flex-direction: column;
                align-items: flex-start;
            }

            .header img {
                width: 100px;
            }
        }
    </style>
</head>
<body>
<div class="container">
    <div class="header">
        <img src="https://cdn-icons-png.flaticon.com/512/3523/3523885.png" alt="Calculatrice">
        <div>
            <h1>Un outil simple, pensé pour les pros</h1>
            <p class="text">Pensé d'abord pour un contrôleur de gestion indépendant, ce site a pour but de simplifier au maximum la gestion quotidienne.</p>
        </div>
    </div>

    <div class="section">
        <h2>Pourquoi cet outil ?</h2>
        <p>
            Les outils classiques sont souvent trop lourds, complexes, ou trop généralistes. Celui-ci se concentre uniquement sur l'essentiel :
            clients, rendez-vous, factures, notes. <br>
            Il est rapide à prendre en main, visuellement clair, et personnalisable selon les besoins.
        </p>
    </div>

    <div class="section">
        <h2>Un design volontairement épuré</h2>
        <p>
            Le style est simple, mais efficace : pas de surcharge visuelle, tout est direct. Cela rend l'outil particulièrement fluide, même sur des ordinateurs modestes ou en mobilité.
        </p>
    </div>

    <div class="section">
        <h2>Des possibilités pour demain</h2>
        <p>
            Le site peut encore évoluer : statistiques, exports Excel, rappels automatiques, envoi de factures par e-mail, etc. Il est prêt à s’adapter à toutes les idées futures.
        </p>
    </div>

    <div class="section">
        <h2>Et pas que pour les contrôleurs de gestion...</h2>
        <p>
            Ce type de site conviendrait aussi à :<br>
            <ul>
                <li>Coachs et consultants</li>
                <li>Indépendants du bien-être (sophrologue, ostéo...)</li>
                <li>Petits commerçants ou auto-entrepreneurs</li>
                <li>Assistants freelances</li>
                <li>Formateurs indépendants</li>
            </ul>
        </p>
    </div>

    <div class="retour">
        <a href="{{ route('accueil') }}">← Retour à l’accueil</a>
    </div>
</div>
</body>
</html>
