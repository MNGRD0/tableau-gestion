<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Connexion Admin</title>
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

        input[type="text"],
        input[type="password"] {
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
        <!-- "main" indique que c'est le contenu principal de la page (meilleure accessibilité) -->
        <h2>Connexion Admin</h2>

        <form action="{{ route('connexion') }}" method="POST">
            <!-- Envoie le formulaire vers la route nommée "connexion" (définie dans web.php) avec la méthode POST -->
            @csrf
            <!-- Jeton CSRF pour la sécurité (protège contre les fausses soumissions de formulaire) -->

            <label for="nom_admin">Nom d'utilisateur</label>
            <div class="champ">
                <input type="text" name="nom_admin" id="nom_admin" required>
                <!-- Champ pour entrer le nom d'utilisateur (obligatoire) -->
            </div>

            <label for="mot_de_passe">Mot de passe</label>
            <div class="champ">
                <input type="password" name="mot_de_passe" id="mot_de_passe" required>
                <!-- Champ pour entrer le mot de passe (obligatoire) -->

                <span class="toggle-mdp" onclick="togglePassword()" title="Afficher ou masquer le mot de passe">👁️</span>
                <!-- Petit bouton œil pour afficher/cacher le mot de passe  et le span sert à mettre l'oeil
                  en ligne et pas aller à la ligne directement 
                  le onclick événement pour que quand on clique ça transforme ça change le type du champ (mot de passe ↔ texte)-->
            </div>

            <button type="submit" class="btn">Se connecter</button>
            <!-- Bouton pour envoyer le formulaire -->

            @if(session('erreur'))
                <div class="erreur">{{ session('erreur') }}</div>
                <!-- Si une erreur existe dans la session (ex : identifiants incorrects), on l'affiche ici -->
            @endif
        </form>

        <!-- Lien vers la page d'accueil -->
        <a href="{{ route('accueil') }}" class="retour-accueil">← Retour à l’accueil</a>
    </main>

    <script>
        // Pour la visibilité du mot de passe : 
        function togglePassword() {
            const input = document.getElementById('mot_de_passe');
            // On récupère l'élément du champ mot de passe

            const type = input.getAttribute('type');
            // On regarde si le type est "password" ou "text"

            input.setAttribute('type', type === 'password' ? 'text' : 'password');
            // Si c'est "password", on le change en "text" pour l'afficher, sinon on le remet en "password"
        }
    </script>
</body>
</html>
