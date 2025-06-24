<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tableau de bord</title>
    <style>
        body { 
            font-family: Arial; 
            margin: 0;
        }

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

        nav a.active {
            color: white;
            text-decoration: underline;
        }

        nav a:hover {
            color: white;
        }

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

        .mobile-nav a {
            margin: 10px 0;
            color: #333;
        }

        .content {
            padding: 20px;
        }

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
    
    <header>
        <div>
            <a href="{{ route('clients.index') }}" class="{{ request()->routeIs('clients.index') ? 'active' : '' }}""><img src="{{ asset('images/Finance.png') }}" alt="Logo"></a>
        </div>

        <nav>
            <a href="{{ route('clients.index') }}" class="{{ request()->routeIs('clients.index') ? 'active' : '' }}">Clients</a>
            <a href="{{ route('rdv.index') }}" class="{{ request()->routeIs('rdv.index') ? 'active' : '' }}">Rendez-vous</a>
            <a href="{{ route('factures.index') }}" class="{{ request()->routeIs('factures.index') ? 'active' : '' }}">Factures</a>
            <a href="{{ route('notes.index') }}" class="{{ request()->routeIs('notes.index') ? 'active' : '' }}">Notes</a>
            <span>| 👤</span>
            <a href="#">Déconnexion</a>
        </nav>

        <div class="burger" onclick="toggleMenu()">
            <div></div>
            <div></div>
            <div></div>
        </div>

        <div class="mobile-nav" id="mobileNav">
            <a href="{{ route('clients.index') }}">Clients</a>
            <a href="{{ route('rdv.index') }}">Rendez-vous</a>
            <a href="#">Factures</a>
            <a href="#">Notes</a>
            <a href="#">Déconnexion</a>
        </div>
    </header>

    <div class="content">
        @yield('content')
    </div>

    <script>
        function toggleMenu() {
            const nav = document.getElementById('mobileNav');
            nav.classList.toggle('show');
        }
    </script>
</body>
</html>
