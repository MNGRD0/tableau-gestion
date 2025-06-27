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
        }

        h2 {
            text-align: center;
            margin-bottom: 20px;
            color: #3490dc;
        }

        label {
            font-weight: bold;
            display: block;
            margin-top: 15px;
        }

        .champ {
            position: relative;
            margin-top: 5px;
        }

        input[type="text"],
        input[type="password"] {
            width: 100%;
            padding: 10px 40px 10px 10px; /* espace pour l'œil */
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
    </style>
</head>
<body>
    <div class="login-box">
        <h2>Connexion Admin</h2>

        <form action="{{ route('connexion') }}" method="POST">
            @csrf

            <label for="nom_admin">Nom d'utilisateur</label>
            <div class="champ">
                <input type="text" name="nom_admin" id="nom_admin" required>
            </div>

            <label for="mot_de_passe">Mot de passe</label>
            <div class="champ">
                <input type="password" name="mot_de_passe" id="mot_de_passe" required>
                <span class="toggle-mdp" onclick="togglePassword()">👁️</span>
            </div>

            <button type="submit" class="btn">Se connecter</button>

            @if(session('erreur'))
                <div class="erreur">{{ session('erreur') }}</div>
            @endif
        </form>
    </div>

    <script>
        
        function togglePassword() {
            const input = document.getElementById('mot_de_passe');
            const type = input.getAttribute('type');
            input.setAttribute('type', type === 'password' ? 'text' : 'password');
        }
    </script>
</body>
</html>
