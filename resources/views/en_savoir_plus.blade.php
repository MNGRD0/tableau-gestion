<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>En savoir plus</title>

    <!-- ✅ STYLE CSS en interne -->
    <style>
        /* 🌈 Définition du style global du corps de la page */
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            margin: 0;
            background: linear-gradient(to bottom right, #dff6fd, #f9fcff); /* dégradé de fond */
            color: #333;
        }

        /* ✅ Conteneur principal qui englobe tout le contenu */
        .container {
            max-width: 1000px;
            margin: 60px auto;
            background-color: white;
            padding: 50px;
            border-radius: 20px;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.15);
        }

        /* ✅ En-tête : image + titre + paragraphe */
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

        /* ✅ Bloc de contenu avec titre et fond bleu clair */
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

        /* ✅ Bouton retour en bas de la page */
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

        /* ✅ Responsive : empile les éléments sur petits écrans */
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

<!-- ✅ Contenu principal -->
<div class="container">

    <!-- ✅ En-tête avec image et texte d’introduction -->
    <div class="header">
        <img src="https://cdn-icons-png.flaticon.com/512/3523/3523885.png" alt="Calculatrice">
        <div>
            <h1>Un outil simple, pour les pros et leurs clients</h1>
            <p class="text">
                Développé à l’origine pour un contrôleur de gestion indépendant, ce site permet aujourd’hui à la fois de gérer les données clients et d’offrir un espace personnel à ces derniers.
            </p>
        </div>
    </div>

    <!-- ✅ Sections d’information avec contenu pédagogique -->
    <div class="section">
        <h2>Pourquoi cet outil ?</h2>
        <p>
            Les outils classiques sont souvent lourds, compliqués, ou trop généralistes. Celui-ci se concentre sur l’essentiel : clients, rendez-vous, factures, notes.<br>
            Il offre également une interface simple pour les clients, qui peuvent consulter leurs données en toute autonomie.
        </p>
    </div>

    <div class="section">
        <h2>Un design volontairement épuré</h2>
        <p>
            L'interface est pensée pour être claire, sans surcharge. Que vous soyez professionnel ou client, tout est facile à prendre en main. L’affichage s’adapte aussi bien aux grands écrans qu’aux smartphones.
        </p>
    </div>

    <div class="section">
        <h2>Des fonctionnalités qui évoluent</h2>
        <p>
            L’outil est conçu pour grandir : ajout de statistiques, envoi automatique de documents, rappels par e-mail, notifications clients… Il est prêt à intégrer toutes vos idées.
        </p>
    </div>

    <div class="section">
        <h2>Pour qui exactement ?</h2>
        <p>
            Ce site est idéal pour les contrôleurs de gestion, mais peut convenir aussi à :
            <ul>
                <li>Coachs ou consultants</li>
                <li>Professionnels du bien-être (sophrologues, ostéos…)</li>
                <li>Petites entreprises ou indépendants</li>
                <li>Assistants freelances</li>
                <li>Formateurs</li>
            </ul>
        </p>
    </div>

    <!-- ✅ Bouton retour à la page d’accueil -->
    <div class="retour">
        <a href="{{ route('accueil') }}">← Retour à l’accueil</a>
    </div>
</div>

</body>
</html>
