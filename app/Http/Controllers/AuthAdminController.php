<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;

class AuthAdminController extends Controller
{
    public function formulaireConnexion()
    {
        return view('admin.connexion');
    }

    public function seConnecter(Request $requete)
    {
        $requete->validate([
            'nom_admin' => 'required',
            'mot_de_passe' => 'required',
        ]);

        $admin = Admin::where('nom_admin', $requete->nom_admin)->first();

        if ($admin && Hash::check($requete->mot_de_passe, $admin->mot_de_passe)) {
            Session::put('admin_connecte', $admin->id);
            return redirect()->route('clients.index')->with('succes', 'Connexion réussie.');
        }

        return back()->withErrors(['nom_admin' => 'Identifiants invalides'])->withInput();
    }

    public function seDeconnecter()
    {
        Session::forget('admin_connecte');
        return redirect()->route('admin.connexion')->with('succes', 'Déconnexion réussie.');
    }
}
