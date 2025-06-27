<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Accueil - Outil de gestion</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;700&display=swap" rel="stylesheet">
    <style>
        body {
            margin: 0;
            padding: 0;
            font-family: 'Inter', sans-serif;
            background-color: #f4f6f9;
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }

        .contenu {
            flex: 1;
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 40px;
        }

        .boite {
            background: white;
            padding: 40px;
            border-radius: 20px;
            box-shadow: 0 0 20px rgba(0,0,0,0.1);
            text-align: center;
            max-width: 600px;
        }

        h1 {
            color: #2c3e50;
            margin-bottom: 20px;
        }

        p {
            color: #555;
            font-size: 1.1em;
        }

        .boutons {
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 15px; /* Espace entre les deux boutons */
            margin-top: 30px;
        }

        .bouton {
            display: inline-block;
            padding: 12px 24px;
            background-color: #3490dc;
            color: white;
            text-decoration: none;
            border-radius: 8px;
            font-weight: bold;
            transition: background 0.3s, transform 0.2s;
        }

        .bouton:hover {
            background-color: #2779bd;
            transform: scale(1.05);
        }

        .bouton-secondaire {
            background-color: #38b2ac;
        }

        .bouton-secondaire:hover {
            background-color: #319795;
        }

        footer {
            text-align: center;
            padding: 20px;
            background-color: #e2e8f0;
        }

        .lien-contacter {
            color: #3490dc;
            cursor: pointer;
            font-weight: bold;
        }

        .notif-success {
    background-color: #d4edda;
    color: #155724;
    border: 1px solid #c3e6cb;
    padding: 12px;
    margin: 40px auto -40px auto;
    border-radius: 8px;
    max-width: 600px;
    text-align: center;
    font-weight: bold;
}

    </style>
</head>
<body>
        <!-- Message flash de déconnexion -->
@if(session('message'))
    <div class="notif-success">
        {{ session('message') }}
    </div>
@endif
    <div class="contenu">
        <div class="boite">
            <h1>Bienvenue sur votre outil de gestion</h1>
            <p>Ce site a été conçu pour vous aider à gérer facilement vos <strong>clients</strong>, <strong>rendez-vous</strong>, <strong>factures</strong> et <strong>notes</strong>.</p>
            <p>Il est réservé au contrôleur de gestion.</p>
            

            <!-- Bloc de boutons bien espacés -->
            <div class="boutons">
                <a href="{{ route('connexion') }}" class="bouton">Accéder à l’espace personnel</a>
                <a href="{{ route('en_savoir_plus') }}" class="bouton bouton-secondaire">En savoir plus</a>
            </div>
        </div>
    </div>



    <footer>
        <span class="lien-contacter" onclick="contacter()">Contacter</span>
    </footer>

    <script>
        function contacter() {
            alert("Pour toute question, appelez le 06 15 99 25 79");
        }
    </script>

</body>
</html>
