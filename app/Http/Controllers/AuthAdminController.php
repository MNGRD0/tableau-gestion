<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Admin;

class AuthAdminController extends Controller

{
    // Afficher la page de connexion :
    public function formulaire()
    {
        return view('admin.connexion');
        // On charge la vue "admin/connexion.blade.php", là où l’admin entre son nom et mot de passe.
    }

    // Traiter le formulaire de connexion :
    public function connexion(Request $request)
    // Cette fonction s’exécute quand l’admin soumet le formulaire de connexion.
    // "$request" contient les données envoyées (comme le nom et le mot de passe).
    {
        // 🔒 Étape 0 : Validation des champs du formulaire :
        $request->validate([
            'nom_admin' => 'required|string',
            // "required" = requis (le champ ne doit pas être vide)
            // "string" = doit être une chaîne de caractères (texte)

            'mot_de_passe' => 'required|string',
            // "mot_de_passe" est aussi requis et doit être une chaîne de texte
        ]);
        // "validate()" = fonction Laravel qui vérifie les règles indiquées ci-dessus.
        // Si une règle échoue (ex : champ vide), Laravel redirige automatiquement vers la page précédente avec un message d’erreur.
        // On sécurise ainsi le formulaire côté serveur, pour éviter les bugs ou les mauvaises données.

        // 1. Récuperer les infos du formulaire :
        $nom = $request->input('nom_admin');
        $mot_de_passe = $request->input('mot_de_passe');
        // On récupère les champs du formulaire : "nom_admin" : le nom tapé par l’admin et "mot_de_passe" : le mot de passe tapé

        // 2. Chercher un admin avec ce nom :
        $admin = Admin::where('nom_admin', $nom)->first();
        // On cherche dans la base de données un admin dont le nom correspond.
        // "first()" prend le premier résultat trouvé (ou null si aucun).
        // "where()" = "où", c’est une méthode Laravel pour filtrer une colonne (ici : "nom_admin")

        // 3. Si l'admin existe et le mot de passe est correct :
        if ($admin && password_verify($mot_de_passe, $admin->mot_de_passe)) {
            // "password_verify" permet de comparer le mot de passe tapé avec celui enregistré (crypté).
            // "verify" = "vérifier"
            // Si c’est bon, on considère que l’admin est bien connecté.

            // 4. On sauvegarde l'admin en session :
            session(['admin_connecte' => $admin->id]);
            // On enregistre dans la session que cet admin est connecté, avec son identifiant.
            // Cela permet de le reconnaître sur les autres pages.

            // 5. Redirige vers la page clients :
            return redirect()->route('clients.index');
            // On redirige vers la page principale de gestion (ex. liste des clients).
        }

        // Sinon : renvoyer un message d'erreur :
        return redirect()->route('connexion')->with('erreur', 'Identifiants incorrects.');
        // Si l’admin n’existe pas ou que le mot de passe est faux :
        // On le renvoie vers la page de connexion avec un message d’erreur temporaire.
    }

    public function deconnexion()
    {
        session()->invalidate();
        // "invalidate" = invalider, rendre invalide
        // Cette méthode vide complètement la session, ça supprime toutes les infos stockées temporairement (y compris 'admin_connecte')
        // Cela permet d’éviter que quelqu’un récupère des données après la déconnexion.

        session()->regenerateToken();
        // "regenerateToken" = regénérer le jeton de sécurité (appelé "CSRF token" dans Laravel)
        // CSRF = Cross Site Request Forgery (attaque qui envoie des faux formulaires à ta place)
        // Ce token est utilisé dans tous les formulaires avec @csrf, donc on en crée un nouveau pour repartir propre.

        return redirect()->route('accueil')->with('message', 'Vous êtes bien déconnecté.');
        // "redirect()" = redirige vers une autre page.
        // "->route('accueil')" = on redirige vers la route nommée "accueil"
        // "->with('message', '...')" = on envoie un message flash temporaire à la prochaine page, pour dire que la déconnexion a réussi.
    }
}
