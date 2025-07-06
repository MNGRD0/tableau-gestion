<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Créer un compte client</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f6f9;
            display: flex;
            justify-content: center;
            align-items: start;
            padding: 60px 20px;
            min-height: 100vh;
            margin: 0;
        }

        .login-box {
            background: white;
            padding: 30px;
            border-radius: 12px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
            width: 100%;
            max-width: 500px;
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
        input[type="email"],
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
            margin-top: 25px;
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
</head>
<body>
<main> <!-- 👈 zone principale de la page, bonne pour l’accessibilité -->
<div class="login-box">
    <h2>Créer un compte client</h2>

    <form action="{{ route('client.inscrire') }}" method="POST">
        @csrf <!-- Jeton CSRF pour protéger l'envoi du formulaire -->

        <!-- Champ NOM -->
        <label for="nom">Nom complet</label>
        <div class="champ">
            <input type="text" name="nom" id="nom" value="{{ old('nom') }}" required>
            <!-- old('nom') = garde la valeur tapée si le formulaire échoue -->
        </div>

        <!-- Téléphone -->
        <label for="telephone_client">Téléphone</label>
        <div class="champ">
            <input type="text" name="telephone_client" id="telephone_client" value="{{ old('telephone_client') }}" required>
        </div>

        <!-- Email -->
        <label for="email_client">Email</label>
        <div class="champ">
            <input type="email" name="email_client" id="email_client" value="{{ old('email_client') }}" required>
        </div>

        <!-- Adresse -->
        <label for="adresse_client">Adresse</label>
        <div class="champ">
            <input type="text" name="adresse_client" id="adresse_client" value="{{ old('adresse_client') }}" required>
        </div>

        <!-- Code postal -->
        <label for="cp_client">Code postal</label>
        <div class="champ">
            <input type="text" name="cp_client" id="cp_client" value="{{ old('cp_client') }}" required>
        </div>

        <!-- Ville -->
        <label for="ville_client">Ville</label>
        <div class="champ">
            <input type="text" name="ville_client" id="ville_client" value="{{ old('ville_client') }}" required>
        </div>

        <!-- Mot de passe -->
        <label for="mot_de_passe_client">Mot de passe</label>
        <div class="champ">
            <input type="password" name="mot_de_passe_client" id="mot_de_passe_client" required>
            <!-- 👁️ permet d’afficher ou cacher le mot de passe -->
            <span class="toggle-mdp" onclick="togglePassword('mot_de_passe_client')">👁️</span>
        </div>

        <!-- Confirmation -->
        <label for="mot_de_passe_client_confirmation">Confirmer le mot de passe</label>
        <div class="champ">
            <input type="password" name="mot_de_passe_client_confirmation" id="mot_de_passe_client_confirmation" required>
            <span class="toggle-mdp" onclick="togglePassword('mot_de_passe_client_confirmation')">👁️</span>
        </div>

        <!-- Bouton envoyer -->
        <button type="submit" class="btn">Créer mon compte</button>

        <!-- Affichage des erreurs s’il y en a -->
        @if ($errors->any())
            <div class="erreur">
                @foreach ($errors->all() as $erreur)
                    <div>{{ $erreur }}</div>
                @endforeach
            </div>
        @endif
    </form>

    <!-- Lien retour accueil -->
    <a href="{{ route('accueil') }}" class="retour-accueil">← Retour à l’accueil</a>
</div>
</main>

<!-- Script pour activer/désactiver la visibilité du mot de passe -->
<script>
    function togglePassword(id) {
        const input = document.getElementById(id); // on cible le champ
        const type = input.getAttribute('type');   // on regarde s'il est en 'password'
        input.setAttribute('type', type === 'password' ? 'text' : 'password'); // on change dynamiquement
    }
</script>
</body>
</html>