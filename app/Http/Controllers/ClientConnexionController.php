<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Client;
use Illuminate\Support\Facades\Hash;
// On importe "Hash" pour vérifier que le mot de passe entré correspond à celui stocké (crypté).

class ClientConnexionController extends Controller
{
    //Afficher le formulaire de connexion client :
    public function formulaire()
    {
        return view('clients.connexion');
        // Laravel affiche la vue "clients/connexion.blade.php" (Connexion du client)
    }

    //Traite la connexion du client :
    public function connecter(Request $request)
    // Cette méthode traite le formulaire envoyé par le client (email + mot de passe).
    {
        // 🔒 Vérifie que les champs sont bien remplis (validation sécurisée)
        $request->validate([
            'email_client' => 'required|email',              // l'email doit être présent et au bon format
            // "required" = requis (champ obligatoire)
            // "email" = doit être un format email valide (ex : test@mail.com)

            'mot_de_passe_client' => 'required',             // le mot de passe doit être présent
            // "required" = requis, le mot de passe ne peut pas être vide
        ]);
        // "validate()" = vérifie que les champs respectent les règles. Si ce n’est pas le cas, Laravel revient à la page précédente avec des erreurs automatiques.
        // Cela protège des mauvaises données ou tentatives de piratage.

        // On cherche un client dans la base avec l'email donné
        $client = Client::where('email_client', $request->email_client)->first();

        if (!$client || $client->deleted_at) {
            // Si aucun client n’est trouvé OU si le client a été supprimé (soft delete), on affiche une erreur :
            return back()->withErrors([
                'email_client' => 'Ce compte n’existe pas ou a été supprimé.',
            ]);
            // "back()" = revenir à la page précédente
            // "withErrors()" = afficher des messages d’erreurs personnalisés
        }

        // Si un client est trouvé, on vérifie que le mot de passe est correct
        if ($client && Hash::check($request->mot_de_passe_client, $client->mot_de_passe_client)) {
            // "Hash::check(...)" compare le mot de passe tapé avec celui stocké en base (chiffré).
            // Si c’est bon, on connecte le client :

            session(['client_id' => $client->id]);
            // On enregistre l’identifiant du client dans la session → le client est maintenant reconnu comme connecté.
            // "session()" = accède à l’espace temporaire de données du client (le garde connecté)

            return redirect()->route('client.espace');
            // On redirige le client vers son espace personnel (vue où il voit ses données).
        }

        // Si le mot de passe est incorrect ou aucun client trouvé, on renvoie une erreur
        return back()->withErrors([
            'email_client' => 'Identifiants incorrects.',
        ]);
    }

    // Deconnexion du client :
    public function deconnexion()
    {
        session()->invalidate();
        // "invalidate" = invalider complètement la session
        // Cela supprime toutes les données temporaires du client connecté (plus propre et plus sécurisé)

        session()->regenerateToken();
        // "regenerateToken" = regénérer un nouveau jeton CSRF (protection contre les fausses requêtes de formulaire)
        // CSRF = Cross Site Request Forgery (attaque possible sur les formulaires)

        return redirect()->route('accueil')->with('message', 'Vous êtes bien déconnecté.');
        // On le redirige vers la page d’accueil du site
    }
}
