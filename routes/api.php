<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// Les controllers Importer//

use App\Http\Controllers\ElevesController;
use App\Http\Controllers\CoursController;
use App\Http\Controllers\ZoneSupController;

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