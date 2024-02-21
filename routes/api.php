<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// Les controllers Importer//

use App\Http\Controllers\ElevesController;
use App\Http\Controllers\CoursController;
use App\Http\Controllers\ZoneSupController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\MatiereController;
use App\Http\Controllers\ClasseController;
use App\Http\Controllers\EncadreurController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


/*
|--------------------------------------------------------------------------
|                       APK BACK2LEARN
|--------------------------------------------------------------------------
*/


/*----------
API eleves
------------
*/

// authentification

Route::match(['GET','POST'],'inscription_eleves',[ElevesController::class,'inscription_eleves']);
Route::match(['GET','POST'],'connexion_eleves',[ElevesController::class,'connexion_eleves']);
Route::match(['GET','POST'],'generer_otp',[ElevesController::class,'generer_otp']);
Route::match(['GET','POST'],'verifier_otp',[ElevesController::class,'verifier_otp']);


//  Compte
Route::match(['GET','POST'],'afficher_compte',[ElevesController::class,'afficher_compte']);
Route::match(['PUT','POST'],'update_compte',[ElevesController::class,'update_compte']);


//  Factures
Route::match(['GET','POST'],'paye_facture',[ElevesController::class,'paye_facture']);
Route::match(['GET','POST'],'afficher_status_facture',[ElevesController::class,'afficher_status_facture']);
Route::match(['GET','POST'],'status_by_id',[ElevesController::class,'status_by_id']);

//  Cours

Route::match(['GET','POST'],'afficher_cours',[ElevesController::class,'afficher_cours']);
Route::match(['GET','POST'],'afficherCours_Matiere',[ElevesController::class,'afficherCours_Matiere']);

// Classes

Route::match(['GET','POST'],'afficher_classe',[ElevesController::class,'afficher_classe']);

// Matieres

Route::match(['GET','POST'],'afficher_Matiere',[ElevesController::class,'afficher_Matiere']);


/*----------
API Cours
------------
*/

Route::match(['GET','POST'],'afficher_cours',[CoursController::class,'afficher_cours']);
Route::match(['GET','POST'],'CoursById',[CoursController::class,'CoursById']);

/*------------------
API Zone_supervision
--------------------
*/

Route::match(['GET','POST'],'afficher_zone',[ZoneSupController::class,'afficher_zone']);
Route::match(['GET','POST'],'zoneById',[ZoneSupController::class,'zoneById']);


/////////////////////////
    /**API ADMIS */
////////////////////////

/*authentification*/

// inscription admin
Route::match(['GET','POST'],'inscription_admin',[AdminController::class,'inscription_admin']);
// connexion admin
Route::match(['GET','POST'],'connexion_admin',[AdminController::class,'connexion_admin']);
// generer otp
Route::match(['GET','POST'],'generer_otp',[AdminController::class,'generer_otp']);
//verifier otp
Route::match(['GET','POST'],'verifier_otp',[AdminController::class,'verifier_otp']);

/**compte Admin */

// afficher compte admin
Route::match(['GET','POST'],'afficher_compte_AD',[AdminController::class,'afficher_compte_AD']);
// modifier compte admin
Route::match(['PUT','POST'],'update_compteAD',[AdminController::class,'update_compteAD']);


/* Encadreur (admin supervision)*/

// supprimer un Encadreur
Route::match(['DELETE','POST'],'supprimer_encadreur',[AdminController::class,'supprimer_encadreur']);
// modifier les coordonné d'un encadreur
Route::match(['PUT','POST'],'modifier_encadreur',[AdminController::class,'modifier_encadreur']);
// afficher tous les coordonnés d'un encadreur
Route::match(['GET','POST'],'afficher_encadreur',[AdminController::class,'afficher_encadreur']);
// afficher les coordonnées par identifiants Id
Route::match(['GET','POST'],'GetEncadreur_byId',[AdminController::class,'GetEncadreur_byId']);

/* Eleves (admin supervision)*/

//supprimer un eleve
Route::match(['DELETE','POST'],'supprimer_eleves',[AdminController::class,'supprimer_eleves']);

// modifier les coodonnées des eleves
Route::match(['PUT','POST'],'modifier_eleves',[AdminController::class,'modifier_eleves']);

// afficher les coodonnées des eleves
Route::match(['GET','POST'],'afficher_eleves',[AdminController::class,'afficher_eleves']);

// afficher les coodonnées des eleves avec identifiant Id
Route::match(['GET','POST'],'getEleves_byId',[AdminController::class,'getEleves_byId']);

/*  (Cours supervision)*/

// supprimer un cours un eleve
Route::match(['DELETE','POST'],'supprimer_cours',[AdminController::class,'supprimer_cours']);

// modifier un cours
Route::match(['PUT','POST'],'modifier_cours',[AdminController::class,'modifier_cours']);

// afficher les cours
Route::match(['GET','POST'],'afficher_cours',[AdminController::class,'afficher_cours']);

// afficher les cours avec identifiant Id
Route::match(['GET','POST'],'GetCours_byId',[AdminController::class,'GetCours_byId']);



/*  (Facture supervision)*/

//  afficher facture
Route::match(['GET','POST'],'afficher_facture',[AdminController::class,'afficher_facture']);

// modifier Facture
Route::match(['PUT','POST'],'modifier_facture',[AdminController::class,'modifier_facture']);

// supprimer Facture
Route::match(['DELETE','POST'],'supprimer_factureAD',[AdminController::class,'supprimer_factureAD']);

// afficher les Factures avec identifiant Id
Route::match(['GET','POST'],'GetFacture_byId',[AdminController::class,'GetFacture_byId']);

// creer  les Factures 
Route::match(['GET','POST'],'Ajouter_facture',[AdminController::class,'Ajouter_facture']);



/*  (Payement supervision)*/

//  afficher payement
Route::match(['GET','POST'],'afficher_payement',[AdminController::class,'afficher_payement']);

// modifier payement
Route::match(['GET','POST'],'modifier_payement',[AdminController::class,'modifier_payement']);

// supprimer payement
Route::match(['GET','POST'],'supprimer_payement',[AdminController::class,'supprimer_payement']);

// afficher les payements avec identifiant Id
Route::match(['GET','POST'],'GetPayment_byId',[AdminController::class,'GetPayment_byId']);

// creer  les payements
Route::match(['GET','POST'],'ajouter_payement',[AdminController::class,'ajouter_payement']);


/*  (Zone de  supervision)*/

//  afficher zone
Route::match(['GET','POST'],'afficher_zoneSupAD',[AdminController::class,'afficher_zoneSupAD']);

// modifier zone
Route::match(['PUT','POST'],'modifier_ZoneSup',[AdminController::class,'modifier_ZoneSup']);

// supprimer supprimer
Route::match(['DELETE','POST'],'supprimer_ZoneSupAD',[AdminController::class,'supprimer_ZoneSupAD']);

// creer  les Zones
Route::match(['GET','POST'],'ajouterZone_sup',[AdminController::class,'ajouterZone_sup']);



/*  (Classe  supervision)*/

//  ajouter classe
Route::match(['GET','POST'],'ajouter_classe',[AdminController::class,'ajouter_classe']);

// modifier classe
Route::match(['PUT','POST'],'update_classes',[AdminController::class,'update_classes']);

// supprimer classe
Route::match(['DELETE','POST'],'delete_classes',[AdminController::class,'delete_classes']);

// afficher toute les classes
Route::match(['GET','POST'],'getAll_classes',[AdminController::class,'getAll_classes']);


//////////////////////
    // API Cours//
/////////////////////

// afficher cours
Route::match(['GET','POST'],'afficher_cours',[CoursController::class,'afficher_cours']);
// afficher cours avec identifiant ID
Route::match(['GET','POST'],'CoursById',[CoursController::class,'CoursById']);


/////////////////////////////////
    // API  ZONE SUPERVISION//
////////////////////////////////

// afficher zone
Route::match(['GET','POST'],'afficher_zone',[ZoneSupController::class,'afficher_zone']);
// afficher zone avec identifiant ID
Route::match(['GET','POST'],'zoneById',[ZoneSupController::class,'zoneById']);



/////////////////////////////////
    // API  Matiere//
////////////////////////////////

// afficher MAtiere
Route::match(['GET','POST'],'afficher_matiere',[MatiereController::class,'afficher_matiere']);


/////////////////////////////////
    // API classe//
////////////////////////////////

// afficher classe
Route::match(['GET','POST'],'afficher_classe',[ClasseController::class,'afficher_classe']);



/////////////////////////////////
    // API ENCADREUR//
////////////////////////////////

/**AUTHENTIFICATION */

//INSCRIPTION (ENCADREUR)
Route::match(['GET','POST'],'inscription_encadreur',[EncadreurController::class,'inscription_encadreur']);
// CONNEXION (ENCADREUR)
Route::match(['GET','POST'],'connexion_encadreur',[EncadreurController::class,'connexion_encadreur']);
// GENERER OTP (ENCADREUR)
Route::match(['GET','POST'],'generer_otp',[EncadreurController::class,'generer_otp']);
// VERIFIER OTP (ENCADREUR)
Route::match(['GET','POST'],'verifier_otp',[EncadreurController::class,'verifier_otp']);

/**COMPTE  */

// AFFICHER COMPTE (ENCADREUR)
Route::match(['GET','POST'],'afficher_compte',[EncadreurController::class,'afficher_compte']);
// MODIFIER COMPTE (ENCADREUR)
Route::match(['GET','POST'],'update_compte',[EncadreurController::class,'update_compte']);

/**PAYEMENT */

// AJOUTER PAYEMENT (ENCADREUR)
Route::match(['GET','POST'],'ajouter_payement',[EncadreurController::class,'ajouter_payement']);
// AFFICHER PAYEMENT (ENCADREUR)
Route::match(['GET','POST'],'afficher_payement',[EncadreurController::class,'afficher_payement']);
/**COURS */

// AJOUTER COURS (ENCADREUR)
Route::match(['GET','POST'],'add_cours',[EncadreurController::class,'add_cours']);
// AFFICHER COURS (ENCADREUR)
Route::match(['GET','POST'],'afficher_cours',[EncadreurController::class,'afficher_cours']);
// SUPPRIMER COURS  (ENCADREUR)
Route::match(['GET','POST'],'suppression_cours',[EncadreurController::class,'suppression_cours']);
// MODIFIER COURS  (ENCADREUR)
Route::match(['GET','POST'],'update_cours',[EncadreurController::class,'update_cours']);
// AFFICHER COURS AVEC ID  (ENCADREUR)
Route::match(['GET','POST'],'cours_by_id',[EncadreurController::class,'cours_by_id']);