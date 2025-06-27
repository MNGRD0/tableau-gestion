<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AdminController extends Controller
{
    // ➤ Déconnexion de l'admin
    public function deconnexion()
{
    session()->forget('admin_connecte');

    // Envoie un message flash dans la session
    return redirect()->route('accueil')->with('message', 'Vous êtes bien déconnecté.');
}

}
