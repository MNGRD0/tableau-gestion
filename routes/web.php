<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\RdvController;
use App\Http\Controllers\FactureController;
use App\Http\Controllers\NoteController;
use App\Http\Controllers\AuthAdminController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ClientInscriptionController; // Contrôleur pour l'inscription client
use App\Http\Controllers\ClientConnexionController;

// --- Accueil public (non connecté) ---
Route::get('/', function () {
    return view('accueil'); // page d'accueil publique avec les boutons
})->name('accueil');

// --- Page En savoir plus ---
Route::get('/en-savoir-plus', function () {
    return view('en_savoir_plus'); // page "en savoir plus" stylisée
})->name('en_savoir_plus');

// --- Authentification Admin ---
Route::get('/connexion', [AuthAdminController::class, 'formulaire'])->name('connexion'); // affiche formulaire
Route::post('/connexion', [AuthAdminController::class, 'connexion']); // traite la connexion
Route::post('/admin/deconnexion', [AuthAdminController::class, 'deconnexion'])->name('admin.deconnexion'); // déconnecte l'admin

// --- Clients ---
Route::get('/clients', [ClientController::class, 'index'])->name('clients.index');
Route::get('/clients/ajouter', [ClientController::class, 'creer'])->name('clients.creer');
Route::post('/clients/enregistrer', [ClientController::class, 'enregistrer'])->name('clients.enregistrer');
Route::get('/clients/supprimes', [ClientController::class, 'supprimes'])->name('clients.supprimes');
Route::post('/clients/{id}/restaurer', [ClientController::class, 'restaurer'])->name('clients.restaurer');
Route::delete('/clients/{id}/supprimer-definitivement', [ClientController::class, 'supprimerDefinitivement'])->name('clients.supprimer.definitivement');
Route::delete('/clients/supprimer-tout-definitivement', [ClientController::class, 'supprimerToutDefinitivement'])->name('clients.supprimerToutDefinitivement');
Route::get('/clients/{id}/modifier', [ClientController::class, 'modifier'])->name('clients.modifier');
Route::put('/clients/{id}/modifier', [ClientController::class, 'mettreAJour'])->name('clients.mettreAJour');
Route::delete('/clients/{id}/supprimer', [ClientController::class, 'supprimer'])->name('clients.supprimer');
Route::get('/clients/{id}', [ClientController::class, 'afficher'])->name('clients.afficher');

// --- Rendez-vous ---
Route::get('/rdv', [RdvController::class, 'index'])->name('rdv.index');
Route::get('/rdv/ajouter', [RdvController::class, 'creer'])->name('rdv.creer');
Route::post('/rdv/enregistrer', [RdvController::class, 'enregistrer'])->name('rdv.enregistrer');
Route::get('/rdv/supprimes', [RdvController::class, 'supprimes'])->name('rdv.supprimes');
Route::post('/rdv/{id}/restaurer', [RdvController::class, 'restaurer'])->name('rdv.restaurer');
Route::delete('/rdv/{id}/supprimer-definitivement', [RdvController::class, 'supprimerDefinitivement'])->name('rdv.supprimer.definitivement');
Route::delete('/rdv/supprimer-tout-definitivement', [RdvController::class, 'supprimerToutDefinitivement'])->name('rdv.supprimerToutDefinitivement');
Route::get('/rdv/{id}/modifier', [RdvController::class, 'modifier'])->name('rdv.modifier');
Route::put('/rdv/{id}', [RdvController::class, 'mettre_a_jour'])->name('rdv.mettre_a_jour');
Route::delete('/rdv/{id}', [RdvController::class, 'supprimer'])->name('rdv.supprimer');
Route::get('/rdv/{id}', [RdvController::class, 'afficher'])->name('rdv.afficher');

// --- Factures ---
Route::get('/factures', [FactureController::class, 'index'])->name('factures.index');
Route::get('/factures/ajouter', [FactureController::class, 'creer'])->name('factures.creer');
Route::post('/factures/enregistrer', [FactureController::class, 'enregistrer'])->name('factures.enregistrer');
Route::get('/factures/supprimees', [FactureController::class, 'supprimees'])->name('factures.supprimees');
Route::post('/factures/{id}/restaurer', [FactureController::class, 'restaurer'])->name('factures.restaurer');
Route::delete('/factures/{id}/supprimer-definitivement', [FactureController::class, 'supprimerDefinitivement'])->name('factures.supprimer.definitivement');
Route::delete('/factures/supprimer-tout-definitivement', [FactureController::class, 'supprimerToutDefinitivement'])->name('factures.supprimerToutDefinitivement');
Route::get('/factures/{id}/modifier', [FactureController::class, 'modifier'])->name('factures.modifier');
Route::put('/factures/{id}', [FactureController::class, 'mettreAJour'])->name('factures.mettreAJour');
Route::delete('/factures/{id}', [FactureController::class, 'supprimer'])->name('factures.supprimer');
Route::get('/factures/{id}/pdf', [FactureController::class, 'genererPDF'])->name('factures.pdf');
Route::get('/factures/{id}', [FactureController::class, 'afficher'])->name('factures.afficher');
Route::get('/mon-espace/facture/{id}/pdf', [FactureController::class, 'telechargerPDFClient'])->name('client.facture.pdf');


// --- Notes ---
Route::get('/notes', [NoteController::class, 'index'])->name('notes.index');
Route::get('/notes/creer', [NoteController::class, 'creer'])->name('notes.creer');
Route::post('/notes/enregistrer', [NoteController::class, 'enregistrer'])->name('notes.enregistrer');
Route::get('/notes/supprimes', [NoteController::class, 'supprimes'])->name('notes.supprimes');
Route::post('/notes/{id}/restaurer', [NoteController::class, 'restaurer'])->name('notes.restaurer');
Route::delete('/notes/{id}/supprimer', [NoteController::class, 'supprimer'])->name('notes.supprimer');
Route::delete('/notes/{id}/supprimer-definitivement', [NoteController::class, 'supprimerDefinitivement'])->name('notes.supprimerDefinitivement');
Route::delete('/notes/supprimer-toutes-definitivement', [NoteController::class, 'supprimerToutesDefinitivement'])->name('notes.supprimerToutesDefinitivement');
Route::get('/notes/{id}/modifier', [NoteController::class, 'modifier'])->name('notes.modifier');
Route::put('/notes/{id}/modifier', [NoteController::class, 'mettreAJour'])->name('notes.mettreAJour');
Route::get('/notes/{id}', [NoteController::class, 'afficher'])->name('notes.afficher');

// --- Inscription des clients (partie publique) ---
Route::get('/inscription', [ClientInscriptionController::class, 'afficherFormulaire'])->name('client.inscription'); // Affiche le formulaire d'inscription
Route::post('/inscription', [ClientInscriptionController::class, 'inscrire'])->name('client.inscrire'); // Traite l'inscription client


// --- Connexion client (utilisateur) ---
Route::get('/connexion-client', [ClientConnexionController::class, 'formulaire'])->name('client.connexion');
Route::post('/connexion-client', [ClientConnexionController::class, 'connecter'])->name('client.connecter');
Route::post('/deconnexion-client', [ClientConnexionController::class, 'deconnexion'])->name('client.deconnexion');

// --- Espace client connecté ---
Route::get('/mon-espace', [ClientController::class, 'espace'])->name('client.espace');
Route::get('/mon-profil/modifier', [ClientController::class, 'modifierProfil'])->name('client.profil.modifier');
Route::post('/mon-profil/modifier', [ClientController::class, 'mettreAJourProfil'])->name('client.profil.mettreAJour');

// --- Téléchargement PDF d'une facture (espace client) ---
Route::get('/mes-factures/{id}/pdf', [FactureController::class, 'telechargerPDFClient'])->name('client.factures.pdf');
