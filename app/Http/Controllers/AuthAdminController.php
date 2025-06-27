<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Admin; // pour accéder à la table admin

class AuthAdminController extends Controller
{
    // ➤ Affiche la page de connexion
    public function formulaire()
    {
        return view('admin.connexion'); // va chercher la vue Blade créée plus haut
    }

    // ➤ Traite le formulaire de connexion
    public function connexion(Request $request)
    {
        // 1. Récupère les infos du formulaire
        $nom = $request->input('nom_admin');
        $mot_de_passe = $request->input('mot_de_passe');

        // 2. Cherche un admin avec ce nom
        $admin = Admin::where('nom_admin', $nom)->first();

        // 3. Si l'admin existe et le mot de passe est correct
        if ($admin && password_verify($mot_de_passe, $admin->mot_de_passe)) {
            // 4. On sauvegarde l'admin en session
            session(['admin_connecte' => $admin->id]);

            // 5. Redirige vers la page clients
            return redirect()->route('clients.index');
        }

        // Sinon : renvoyer un message d'erreur
        return redirect()->route('connexion')->with('erreur', 'Identifiants incorrects.');
    }
}
