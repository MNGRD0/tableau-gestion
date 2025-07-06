<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8"> <!-- Définit l'encodage des caractères -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0"> <!-- Pour le responsive mobile -->
    
    <!-- Lien vers le fichier CSS personnalisé (public/css/style.css) -->
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">

    <title>Tableau de bord</title>

    <style>
        /* ✅ STYLES DE BASE */

        body { 
            font-family: Arial; 
            margin: 0;
        }

        /* ✅ HEADER du site (barre du haut avec logo et menu) */
        header {
            background: linear-gradient(90deg, rgb(208, 231, 255), rgb(125, 203, 255), rgb(144, 216, 245), rgb(194, 238, 255));
            padding: 2px 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.4);
            height: 60px;
            position: relative;
        }

        header img {
            height: 90px;
        }

        /* ✅ Menu principal (bureau) */
        nav {
            display: flex;
            align-items: center;
            gap: 15px;
        }

        nav a {
            text-decoration: none;
            color: #333;
            font-weight: bold;
        }

        /* ✅ Lien actif mis en évidence */
        nav a.active {
            color: white;
            text-decoration: underline;
        }

        nav a:hover {
            color: white;
        }

        /* ✅ Icône burger pour menu mobile */
        .burger {
            display: none;
            flex-direction: column;
            cursor: pointer;
        }

        .burger div {
            width: 25px;
            height: 3px;
            background-color: #333;
            margin: 4px 0;
        }

        /* ✅ Menu déroulant mobile */
        .mobile-nav {
            display: none;
            flex-direction: column;
            background-color: white;
            position: absolute;
            top: 60px;
            left: 0;
            width: 100%;
            padding: 10px 20px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.2);
        }

        .mobile-nav a,
        .mobile-nav form {
            margin: 10px 0;
        }

        /* ✅ Bouton déconnexion (stylisé comme lien) */
        .logout-button.lien {
            background: none;
            border: none;
            font-weight: bold;
            font-family: inherit;
            font-size: inherit;
            color: #333;
            text-decoration: none;
            padding: 0;
            margin: 0;
            cursor: pointer;
        }

        .logout-button.lien:hover {
            color: white;
            text-decoration: underline;
        }

        /* ✅ Contenu principal (partie @yield) */
        .content {
            padding: 20px;
        }

        /* ✅ ADAPTATION MOBILE */
        @media screen and (max-width: 768px) {
            nav {
                display: none;
            }

            .burger {
                display: flex;
            }

            .mobile-nav.show {
                display: flex;
            }

            header img {
                height: 60px;
            }
        }
    </style>
</head>

<body>

    <!-- ✅ En-tête avec logo + navigation -->
    <header>
        <div>
            <!-- Logo cliquable qui redirige vers la bonne page selon si client connecté ou non -->
            <a href="{{ session('client_id') ? route('client.espace') : route('clients.index') }}">
                <img src="{{ asset('images/Finance.png') }}" alt="Logo">
            </a>
        </div>

        <!-- ✅ Menu principal -->
        <nav>
            @if (session()->has('client_id'))
                <!-- CLIENT CONNECTÉ -->
                <a href="{{ route('client.espace') }}" class="{{ request()->routeIs('client.espace') ? 'active' : '' }}">Accueil</a>
                <a href="{{ route('client.profil.modifier') }}" class="{{ request()->routeIs('client.profil.modifier') ? 'active' : '' }}">Mon profil</a>

                <!-- Bouton déconnexion client -->
                <form action="{{ route('client.deconnexion') }}" method="POST" style="display:inline;">
                    @csrf
                    <button type="submit" class="logout-button lien">Déconnexion</button>
                </form>
            @else
                <!-- ADMIN CONNECTÉ -->
                <a href="{{ route('clients.index') }}" class="{{ request()->routeIs('clients.index') ? 'active' : '' }}">Clients</a>
                <a href="{{ route('rdv.index') }}" class="{{ request()->routeIs('rdv.index') ? 'active' : '' }}">Rendez-vous</a>
                <a href="{{ route('factures.index') }}" class="{{ request()->routeIs('factures.index') ? 'active' : '' }}">Factures</a>
                <a href="{{ route('notes.index') }}" class="{{ request()->routeIs('notes.index') ? 'active' : '' }}">Notes</a>

                <!-- Icône utilisateur -->
                <span>| 👤</span>

                <!-- Bouton déconnexion admin -->
                <form action="{{ route('admin.deconnexion') }}" method="POST" style="display:inline;">
                    @csrf
                    <button type="submit" class="logout-button lien">Déconnexion</button>
                </form>
            @endif
        </nav>

        <!-- ✅ Menu burger (visible uniquement en mobile) -->
        <div class="burger" onclick="toggleMenu()">
            <div></div>
            <div></div>
            <div></div>
        </div>

        <!-- ✅ Menu mobile déroulant -->
        <div class="mobile-nav" id="mobileNav">
            @if (session()->has('client_id'))
                <a href="{{ route('client.espace') }}">Accueil</a>
                <a href="{{ route('client.profil.modifier') }}">Mon profil</a>
                <form action="{{ route('client.deconnexion') }}" method="POST">
                    @csrf
                    <button type="submit" class="logout-button lien">Déconnexion</button>
                </form>
            @else
                <a href="{{ route('clients.index') }}">Clients</a>
                <a href="{{ route('rdv.index') }}">Rendez-vous</a>
                <a href="{{ route('factures.index') }}">Factures</a>
                <a href="{{ route('notes.index') }}">Notes</a>
                <form action="{{ route('admin.deconnexion') }}" method="POST">
                    @csrf
                    <button type="submit" class="logout-button lien">Déconnexion</button>
                </form>
            @endif
        </div>
    </header>

    <!-- ✅ Contenu dynamique (affiché selon la page avec @section) -->
    <div class="content">
        @yield('content')
    </div>

    <!-- ✅ Script pour activer ou fermer le menu mobile -->
    <script>
        function toggleMenu() {
            const nav = document.getElementById('mobileNav');
            nav.classList.toggle('show');
        }
    </script>

</body>
</html>
