<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Connexion Client</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f6f9;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .login-box {
            background: white;
            padding: 30px;
            border-radius: 12px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
            width: 100%;
            max-width: 400px;
            text-align: center;
        }

        h2 {
            margin-bottom: 20px;
            color: #3490dc;
        }

        label {
            font-weight: bold;
            display: block;
            margin-top: 15px;
            text-align: left;
        }

        .champ {
            position: relative;
            margin-top: 5px;
        }

        input[type="email"],
        input[type="password"],
        input[type="text"] {
            width: 100%;
            padding: 10px 40px 10px 10px;
            border-radius: 5px;
            border: 1px solid #ccc;
            box-sizing: border-box;
        }

        .toggle-mdp {
            position: absolute;
            top: 50%;
            right: 10px;
            transform: translateY(-50%);
            cursor: pointer;
            color: #888;
            font-size: 16px;
        }

        .btn {
            width: 100%;
            background-color: #3490dc;
            color: white;
            padding: 10px;
            margin-top: 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-weight: bold;
        }

        .btn:hover {
            background-color: #2779bd;
        }

        .erreur {
            color: red;
            font-size: 0.9em;
            margin-top: 10px;
            text-align: center;
        }

        .retour-accueil {
            display: inline-block;
            margin-top: 25px;
            color: #3490dc;
            text-decoration: none;
            font-weight: bold;
        }

        .retour-accueil:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <main class="login-box">
        <h2>Connexion Client</h2>

        <form action="{{ route('client.connecter') }}" method="POST">
            <!-- Le formulaire envoie les données à la route nommée "client.connecter" -->
            @csrf
            <!-- Jeton CSRF pour la sécurité contre les fausses soumissions -->

            <label for="email_client">Adresse email</label>
            <div class="champ">
                <input type="email" name="email_client" id="email_client" required>
                <!-- Champ pour entrer l'email, avec type "email" et requis -->
            </div>

            <label for="mot_de_passe_client">Mot de passe</label>
            <div class="champ">
                <input type="password" name="mot_de_passe_client" id="mot_de_passe_client" required>
                <!-- Champ pour entrer le mot de passe (obligatoire) -->

                <span class="toggle-mdp" onclick="togglePassword()" title="Afficher ou masquer le mot de passe">👁️</span>
                <!-- Icône œil cliquable pour afficher/cacher le mot de passe -->
            </div>

            <button type="submit" class="btn">Se connecter</button>
            <!-- Bouton pour soumettre le formulaire -->

            @if ($errors->any()) <!-- "Est-ce qu’il y a au moins une erreur de validation ?" -->
                <div class="erreur">
                    {{ $errors->first() }} <!-- Ça affiche le premier message d’erreur de la liste. -->
                </div>
                <!-- Affiche la première erreur de validation retournée par Laravel -->
            @endif
        </form>

        <!-- Lien vers la page d'accueil -->
        <a href="{{ route('accueil') }}" class="retour-accueil">← Retour à l’accueil</a>
    </main>

    <script>
        // Fonction pour afficher/masquer le mot de passe
        function togglePassword() {
            const input = document.getElementById('mot_de_passe_client');
            const type = input.getAttribute('type');
            input.setAttribute('type', type === 'password' ? 'text' : 'password');
        }
    </script>
</body>
</html>
