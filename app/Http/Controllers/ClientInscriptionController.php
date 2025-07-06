<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Client;
use Illuminate\Support\Facades\Hash;
// "Hash" = classe Laravel qui permet de chiffrer les mots de passe avant de les stocker

class ClientInscriptionController extends Controller
// Ce contrôleur gère l'inscription des clients (formulaire + enregistrement).
{
    //Afficher le formulaire d'inscription client :
    public function afficherFormulaire()
    {
        // Affiche la page Blade : resources/views/clients/inscription.blade.php
        return view('clients.inscription');
        // "view()" = fonction Laravel qui charge une vue Blade
    }

    //Traiter les données du formulaire d'inscription :
    public function inscrire(Request $request)
    {
        // 🔒 Valide les champs remplis par le client dans le formulaire :
        $request->validate([
            'nom' => 'required|string|max:255',
            // "required" = requis (champ obligatoire)
            // "string" = doit être du texte
            // "max:255" = longueur maximale de 255 caractères

            'telephone_client' => 'required|string|max:20',
            // Champ requis, texte, max 20 caractères

            'email_client' => 'required|email|unique:client,email_client',
            // "email" = format email valide
            // "unique:client,email_client" = l'email ne doit pas déjà exister dans la table client (colonne email_client)

            'mot_de_passe_client' => 'required|string|min:6|confirmed',
            // "min:6" = minimum 6 caractères
            // "confirmed" = Laravel s’attend à un champ "mot_de_passe_client_confirmation" pour vérifier que les 2 mots de passe sont identiques

            'adresse_client' => 'required|string|max:255',
            'cp_client' => 'required|string|max:10',
            'ville_client' => 'required|string|max:100',
            // Validation classique sur les champs d'adresse
        ]);
        // Si un champ est incorrect ou manquant, Laravel renvoie automatiquement à la page précédente avec les erreurs.

        // ✅ Enregistrer le nouveau client dans la base de données :
        Client::create([
            'nom' => $request->nom,
            'telephone_client' => $request->telephone_client,
            'email_client' => $request->email_client,
            'mot_de_passe_client' => Hash::make($request->mot_de_passe_client),
            // "Hash::make()" = chiffre le mot de passe avant de le stocker → personne ne peut le lire en clair

            'adresse_client' => $request->adresse_client,
            'cp_client' => $request->cp_client,
            'ville_client' => $request->ville_client,
        ]);
        // "Client::create()" = enregistre un nouveau client dans la base de données en une seule commande

        // Redirige vers la page de connexion avec un message flash temporaire
        return redirect()->route('client.connexion')->with('success', 'Compte créé avec succès. Vous pouvez vous connecter.');
        // "redirect()->route(...)" = redirige vers la route nommée "client.connexion"
        // "with('success', ...)" = on envoie un message temporaire (flash) à la vue suivante
    }
}
