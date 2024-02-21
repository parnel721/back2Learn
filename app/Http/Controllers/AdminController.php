<?php

namespace App\Http\Controllers;

use App\Models\Administareur;
use App\Models\Classe;
use App\Models\Facture;
use App\Models\Cour;
use App\Models\Encadreur;
use App\Models\Eleve;
use App\Models\Matiere;
use App\Models\User;
use App\Models\ZoneSupervision;

use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    //////////////////////////////////////////
    //-----------CRUD ADMIN-----------------*
    //////////////////////////////////////////
    //////////////////////////////////////////


    // NB: signification des accronymes suivants

    //TDV : Traitement des données avec validator
    //VDD : Verification des données 
    //EPs : permet de cibler une erreur provenant du serveur


/*-----------------------
/**Authentification */
//-----------------------

//inscription de l'Admin

function inscription_admin(Request $request){

    try {
        //TDV (nom admin)
        $validateNomAD= validator::make($request->all(),[
            'nom'=>'required|min:3'
        ]);
        if ($validateNomAD->fails()){
            return response()->json([
            "statuscode"=>404,
            "status"    =>false,
            "Message"   =>'veillez entrer votre nom',
            "errors"    =>$validateNomAD->errors()

            ]);
        }

        //TDV (Prenom admin)
        $validatePrenAD= validator::make($request->all(),[
            'prenom'=>'required|min:3'
        ]);
        if ($validatePrenAD->fails()){
            return response()->json([
            "statuscode"=>404,
            "status"    =>false,
            "Message"   =>'veillez entrer votre prenom',
            "errors"    =>$validatePrenAD->errors()

            ]);
        }

        //TDV (dte_naissance admin)
        $validateDteAD=validator::make($request->all(),[
            'date_Naissance'=>'required'
        ]);
        if ($validateDteAD->fails()){
            return response()->json([
            "statuscode"=>404,
            "status"    =>false,
            "Message"   =>'veillez entrer votre date de naissance',
            "errors"    =>$validateDteAD->errors()

            ]);
        }


        //TDV (contact admin)
        $validateCont=validator::make($request->all(),[
            'telephone'=>'required|min:10|unique:administareur'
        ]);
        if ($validateCont->fails()){
            return response()->json([
            "statuscode"=>404,
            "status"    =>false,
            "Message"   =>'veillez entrer votre contact',
            "errors"    =>$validateCont->errors()

            ]);
        }

       //TDV (email admin)
       $validatemailAD=validator::make($request->all(),[
        'email'=>'required'
    ]);
    if ($validatemailAD->fails()){
        return response()->json([
        "statuscode"=>404,
        "status"    =>false,
        "Message"   =>'veillez entrer votre E-mail',
        "errors"    =>$validatemailAD->errors()

        ]);
    }

       //TDV (password admin)
       $validatPwdAD=validator::make($request->all(),[
        'password'=>'required'
    ]);
    if ($validatPwdAD->fails()){
        return response()->json([
        "statuscode"=>404,
        "status"    =>false,
        "Message"   =>'veillez entrer votre mot de passe',
        "errors"    =>$validatPwdAD->errors()

        ]);
    }

       //TDV (CNI admin)
       $validatCn=validator::make($request->all(),[
        'cni'=>'required'
    ]);
    if ($validatCn->fails()){
        return response()->json([
        "statuscode"=>404,
        "status"    =>false,
        "Message"   =>'veillez entrer votre numero cni',
        "errors"    =>$validatCn->errors()

        ]);
    }


       //TDV (Ville admin)
       $validatVil=validator::make($request->all(),[
        'ville'=>'required'
    ]);
    if ($validatVil->fails()){
        return response()->json([
        "statuscode"=>404,
        "status"    =>false,
        "Message"   =>'veillez entrer votre ville',
        "errors"    =>$validatVil->errors()

        ]);
    }


       //TDV (commune_quatier admin)
       $validatC_QAD=validator::make($request->all(),[
        'commune_quatier'=>'required'
    ]);
    if ($validatC_QAD->fails()){
        return response()->json([
        "statuscode"=>404,
        "status"    =>false,
        "Message"   =>'veillez entrer votre commune ou quatier',
        "errors"    =>$validatC_QAD->errors()

        ]);
    }

      /////////////////////////////
      // OUVERTURE D'UN COMPTE//
      /////////////////////////////

      $user= User::create([
        'telephone' =>$request->telephone,
      ]);

      $Admin=Administareur::create([
            "nom"                   =>$request->nom,
            "prenom"                =>$request->prenom,
            "date_naissance"        =>$request->date_Naissance,
            "telephone"             =>$request->telephone,
            "email"                 =>$request->email,
            "password"              =>$request->password,
            "cni"                   =>$request->cni,
            "ville"                 =>$request->ville,
            "commune_quatier"       =>$request->commune_quatier,
            "id_users"              =>$user->id,
      ]);


     ///////////////////////////////         
        /** GENERETION DE TOKEN */
      /////////////////////////////

      return response()->json([
        "statuscode"=>200,
        "status"    =>true,
        "Message"   =>"Félicitation votre compte est ouvert avec success",
        "Admin"    =>$Admin,
        'token'     =>$user->createToken("API TOKEN")->plainTextToken
      ],200);




    } catch (\Throwable $th) {
        //EPs
        return response()->json([
            "statuscode"=>500,
            "status"    =>false,
            "Message"   =>$th->getMessage()
        ],500);
    }

}


// connexion au compte de l'Admin

public function connexion_admin(Request $request){
    try {
        // Traitement des données avec Validator
        $validatortel = Validator::make($request->all(), [
            "telephone" =>'required|min:10'
        ]);

        // Vérification des données
        if ($validatortel->fails()) {
            return response()->json([
                "statuscode" =>404,
                "status"     =>false,
                "message"    =>'Veuillez fournir votre numéro de téléphone',
                "errors"     =>$validatortel->errors()
            ]);
        }

        // Nouvelle connexion
        $Admin = Administareur::firstWhere('telephone', $request->telephone);

        if ($Admin) {
            $user = User::firstWhere('telephone', $request->telephone)->firstOrFail();
            return response()->json([
                "statuscode" =>200,
                "status"     =>true,
                "message"    =>"Connecté avec succès",
                "Administrateur"  =>$Admin,
                "Token"      =>$user->createToken("API TOKEN")->plainTextToken
            ],200);
        } else {
            return response()->json([
                "statuscode" =>401,
                "status"     =>false,
                "message"    =>"Numéro de téléphone incorrect",
                "compte"     =>[],
            ],401);
        }

    } catch (\Throwable $th) {
        // Gestion des erreurs
        return response()->json([
            "statuscode" =>500,
            "status"     =>false,
            "message"    =>$th->getMessage()
        ], 500);

    }
}

//generer otp (admin)
function generer_otp(Request $request){

}

//verifier otp (admin)
function Verifier_otp(Request $request){
    
}



//////////////////////
///COMPTE ADMIN//
////////////////////

//afficher les informations de l'Admin

function afficher_compte_AD(Request $request){

    try {
        $admin=Administareur::all();
    
        if (count($admin)!==0){
          return response()->json([
            "statuscode"=>200,
            "status"    =>true,
            "Message"   =>'affichage du compte avec succès',
            "compte"    =>$admin
          ]);
        }else{
          return response()->json([
            "statuscode"=>404,
            "status"    =>False,
            'Message'   =>'Aucun compte trouvé',
          ],404); 
        }
    
      } catch (\Throwable $th) {
        //EPs
    
        return response()->json([
          "statuscode"=>500,
          "status"    =>false,
          "Message"   =>$th->getMessage()
        ],500);
    
      }


}


// modifier les infos  de l'encadreur

function update_compteAD(Request $request){
    try {
  
      // poser une requete
      $idgestionnaires =  $request->idgestionnaires;
      $nom             =  $request->nom;
      
      // code 
     
      $updatAD=Administareur::where('idgestionnaires',$idgestionnaires)->update(["idgestionnaires"=>$idgestionnaires,"nom"=>$nom]);
      
      //VDD
  
      if($updatAD==0){
        return response()->json([
          "statuscode"=>404,
          "status"    =>false,
          "message"   =>'aucune modification effectué'
        ],404);
      }
      else{
        return response()->json([
          "statusCode"=>200,
          "status" =>true,
          "message"=>"modification  effectué avec succes",
          "compte"=>$updatAD
      ],200); 
  
      }
  
    } catch (\Throwable $th) {
      //EPs
      return response()->json([
        "statuscode"=>500,
        "status"    =>false,
        "Message"   =>$th->getMessage()
      ],500);
  
    }
  }




//////////////////////
///COMPTE ENCADREUR//
////////////////////

//afficher les informations de l'encadreur par l'admin

function afficher_encadreur(Request $request){

    try {
        $Encadreur=Encadreur::all();
    
        if (count($Encadreur)!==0){
          return response()->json([
            "statuscode"=>200,
            "status"    =>true,
            "Message"   =>'affichage du compte avec succès',
            "Encadreur"    =>$Encadreur
          ]);
        }else{
          return response()->json([
            "statuscode"=>404,
            "status"    =>False,
            'Message'   =>'Aucun compte trouvé',
          ],404); 
        }
    
      } catch (\Throwable $th) {
        //EPs
    
        return response()->json([
          "statuscode"=>500,
          "status"    =>false,
          "Message"   =>$th->getMessage()
        ],500);
    
      }


}


// modifier les infos  de l'encadreur  par l'admin

function modifier_encadreur(Request $request){
    try {
  
      // poser une requete
      $idencadreurs =  $request->idencadreurs;
      $nom          =  $request->nom;
      
      // code 
     
      $updatEn=Encadreur::where('idencadreurs',$idencadreurs)->update(["idencadreurs"=>$idencadreurs,"nom"=>$nom]);
      
      //VDD
  
      if($updatEn==0){
        return response()->json([
          "statuscode"=>404,
          "status"    =>false,
          "message"   =>'aucune modification effectué'
        ],404);
      }
      else{
        return response()->json([
          "statusCode"=>200,
          "status" =>true,
          "message"=>"modification  effectué avec succes",
          "compte"=>$updatEn
      ],200); 
  
      }
  
    } catch (\Throwable $th) {
      //EPs
      return response()->json([
        "statuscode"=>500,
        "status"    =>false,
        "Message"   =>$th->getMessage()
      ],500);
  
    }
  }


// suppression d'un encadreur par identifiant (admin)

function supprimer_encadreur(Request $request){
    try {
        // Code...

        $encad =Encadreur::where('idencadreurs',$request->idencadreurs);

        if (!$encad) {
            return response()->json([
                "statusCode" => 404,
                "status" => false,
                "message" => "Encadreur non trouvé."
            ], 404);
        }
        else{

        $encad->delete();

        return response()->json([
            "statusCode" => 200,
            "status" => true,
            "message" => "Suppression effectuée avec succès",
            "Encadreur" => $encad
        ], 200);

        }

    } catch (\Throwable $th) {
        return response()->json([
            "statusCode" => 500,
            "status" => false,
            "message" => $th->getMessage()
        ], 500);
    }
}



//affichage des encadreurs par l'id (admin)

function GetEncadreur_byId(Request $request){
    try {
        // Code...

        $EncadbyId = Encadreur::firstWhere('idencadreurs', $request->idencadreurs);

        if (!$EncadbyId) {
            return response()->json([
                "statusCode" => 404,
                "status" => false,
                "message" => "Cours non trouvé."
            ], 404);
        }

        return response()->json([
            "statusCode" => 200,
            "status" => true,
            "message" => "Affichage effectué avec succès",
            "Encadreur" => $EncadbyId
        ], 200);

    } catch (\Throwable $th) {
        return response()->json([
            "statusCode" => 500,
            "status" => false,
            "message" => $th->getMessage()
        ], 500);
    }
}


//////////////////////
///COMPTE ELEVES//
////////////////////

//afficher les informations de l'élèves par l'admin

function afficher_eleves(Request $request){

    try {
        $ELev=Eleve::all();
    
        if (count($ELev)!==0){
          return response()->json([
            "statuscode"=>200,
            "status"    =>true,
            "Message"   =>'affichage du compte avec succès',
            "Eleves"    =>$ELev
          ]);
        }else{
          return response()->json([
            "statuscode"=>404,
            "status"    =>False,
            'Message'   =>'Aucun compte trouvé',
          ],404); 
        }
    
      } catch (\Throwable $th) {
        //EPs
    
        return response()->json([
          "statuscode"=>500,
          "status"    =>false,
          "Message"   =>$th->getMessage()
        ],500);
    
      }


}


// modifier les infos  de l'élèves  par l'admin

function modifier_eleves(Request $request){
    try {
  
      // poser une requete
      $ideleves =  $request->ideleves;
      $nom          =  $request->nom;
      
      // code 
     
      $updatEl=Eleve::where('ideleves',$ideleves)->update(["ideleves"=>$ideleves,"nom"=>$nom]);
      
      //VDD
  
      if($updatEl==0){
        return response()->json([
          "statuscode"=>404,
          "status"    =>false,
          "message"   =>'aucune modification effectué'
        ],404);
      }
      else{
        return response()->json([
          "statusCode"=>200,
          "status" =>true,
          "message"=>"modification  effectué avec succes",
          "compte"=>$updatEl
      ],200); 
  
      }
  
    } catch (\Throwable $th) {
      //EPs
      return response()->json([
        "statuscode"=>500,
        "status"    =>false,
        "Message"   =>$th->getMessage()
      ],500);
  
    }
  }


// suppression d'un élèves par identifiant (admin)

function supprimer_eleves(Request $request){
    try {
        // Code...

        $eleves =Eleve::where('ideleves',$request->ideleves);

        if (!$eleves) {
            return response()->json([
                "statusCode" => 404,
                "status" => false,
                "message" => "Encadreur non trouvé."
            ], 404);
        }
        else{

        $eleves->delete();

        return response()->json([
            "statusCode" => 200,
            "status" => true,
            "message" => "Suppression effectuée avec succès",
            "eleves" => $eleves
        ], 200);

        }

    } catch (\Throwable $th) {
        return response()->json([
            "statusCode" => 500,
            "status" => false,
            "message" => $th->getMessage()
        ], 500);
    }
}



//affichage des élèves par l'id (admin)

function getEleves_byId(Request $request){
    try {
        // Code...

        $ElevbyId = Eleve::firstWhere('ideleves', $request->ideleves);

        if (!$ElevbyId) {
            return response()->json([
                "statusCode" => 404,
                "status" => false,
                "message" => "Cours non trouvé."
            ], 404);
        }

        return response()->json([
            "statusCode" => 200,
            "status" => true,
            "message" => "Affichage effectué avec succès",
            "Eleves" => $ElevbyId
        ], 200);

    } catch (\Throwable $th) {
        return response()->json([
            "statusCode" => 500,
            "status" => false,
            "message" => $th->getMessage()
        ], 500);
    }
}


//------------------------
        /** COURS*/
//------------------------


// visionner les cours (Admin)


public function afficher_cours(Request $request){
    try {
        // Code...
        $cours = Cour::all(); // Utilisez une convention de nommage en minuscules pour les variables

        // Vérifiez si des cours sont disponibles
        if ($cours->isEmpty()) {
            return response()->json([
                'statusCode' => 404,
                'status'     => false,
                'message'    => 'Aucun cours disponible!'
            ], 404);
        } else {
            return response()->json([
                'statusCode' => 200,
                'status'     => true,
                'message'    => 'Cours affichés avec succès',
                'cours'      => $cours
            ], 200);
        }

    } catch (\Throwable $th) {
        // Gestion des erreurs
        return response()->json([
            'statusCode' => 500,
            'status'     => false,
            'message'    => $th->getMessage()
        ], 500);
    }
}

  

// modifier les cours (Admin)

function modifier_cours(Request $request)
{
    try {
        //requete
        $idcours= $request->idcours;
        $type_cours= $request->type_cours;

        //code...
        $modif=Cour::where('idcours',$idcours)->update(['idcours'=>$idcours,'type_cours'=>$type_cours]);

        //verification
        if($modif==0){
            return response()->json([
                "statusCode"=>400,
                "status"    =>false,
                "Message"   =>'aucune modification effectuée'
            ]);
        }else{
            return response()->json([
                "statusCode"=>200,
                "status"    =>true,
                "Message"   =>' modification effectuée avec succes',
                "cours"     =>$modif
            ],200);  
        }

    } catch (\Throwable $th) {
        //EPs
        return response()->json([
            "statusCode"=>500,
            "status"=>false,
            "Message"=>$th->getMessage()
        ],500);
    }


}

//affichage des cours par l'id Admin



function GetCours_byId(Request $request){
    try {
        // Code...

        $courById = Cour::firstWhere('idcours', $request->idcours);

        if (!$courById) {
            return response()->json([
                "statusCode" => 404,
                "status" => false,
                "message" => "Cours non trouvé."
            ], 404);
        }

        return response()->json([
            "statusCode" => 200,
            "status" => true,
            "message" => "Affichage effectué avec succès",
            "cours" => $courById
        ], 200);

    } catch (\Throwable $th) {
        return response()->json([
            "statusCode" => 500,
            "status" => false,
            "message" => $th->getMessage()
        ], 500);
    }
}



// suppression de cours par identifiant (Admin)




function supprimer_cours(Request $request){
    try {
        // Code...

        $courbyid =Cour::where('idcours',$request->idcours);

        if (!$courbyid) {
            return response()->json([
                "statusCode" => 404,
                "status" => false,
                "message" => "Cours non trouvé."
            ], 404);
        }
        else{

        $courbyid->delete();

        return response()->json([
            "statusCode" => 200,
            "status" => true,
            "message" => "Suppression effectuée avec succès",
            "cours" => $courbyid
        ], 200);

        }

    } catch (\Throwable $th) {
        return response()->json([
            "statusCode" => 500,
            "status" => false,
            "message" => $th->getMessage()
        ], 500);
    }
}

///-------------------///
//////// FACTURES///////
///------------------///




function Ajouter_facture(Request $request){
    try {
      //TDV (numer de la facture)
      $validateNum=validator::make($request->all(),[
        "numero_fact"=>'required'
      ]);
  //VDD
  
      if($validateNum->fails()){
        return response()->json([
          "statuscode"=>404,
          "status"    =>false,
          "Message"   =>"veillez entrer le numero de la facture",
          "error"     =>$validateNum->errors()
        ],404);
      }
  
  
          //TDV (description facture)
          $validateDes=validator::make($request->all(),[
            "description_fact"=>'required'
          ]);
      //VDD
      
          if($validateDes->fails()){
            return response()->json([
              "statuscode"=>404,
              "status"    =>false,
              "Message"   =>"veillez entrer la description de la facture",
              "error"     =>$validateDes->errors()
            ],404);
          }
      
  
  
          //TDV (niveau d'etude)
          $validateNiv=validator::make($request->all(),[
            "niveau"=>'required'
          ]);
      //VDD
      
          if($validateNiv->fails()){
            return response()->json([
              "statuscode"=>404,
              "status"    =>false,
              "Message"   =>"veillez entrer votre niveau",
              "error"     =>$validateNiv->errors()
            ],404);
          }
  
          //TDV (serie d'etude)
          $validateSerie=validator::make($request->all(),[
            "serie"=>'required'
          ]);
      //VDD
      
          if($validateSerie->fails()){
            return response()->json([
              "statuscode"=>404,
              "status"    =>false,
              "Message"   =>"veillez entrer votre niveau",
              "error"     =>$validateSerie->errors()
            ],404);
          }
  
  
          //TDV (date de la facture)
          $validateDfact=validator::make($request->all(),[
            "date_fact"=>'required'
          ]);
      //VDD
      
          if($validateDfact->fails()){
            return response()->json([
              "statuscode"=>404,
              "status"    =>false,
              "Message"   =>"veillez entrer la date",
              "error"     =>$validateDfact->errors()
            ],404);
          }
  
          //TDV (payement)
          $validatePfact=validator::make($request->all(),[
            "payement"=>'required'
          ]);
      //VDD
      
          if($validatePfact->fails()){
            return response()->json([
              "statuscode"=>404,
              "status"    =>false,
              "Message"   =>"veillez entrer le status du payement",
              "error"     =>$validatePfact->errors()
            ],404);
          }
  
  
          //////////////////////////
            //PAYER SA FACTURE//
          //////////////////////////
  
  $fact=Facture::create([
    'numero_fact'       =>$request->numero_fact,
    'description_fact'  =>$request->description_fact,
    'niveau'            =>$request->niveau,
    'serie'             =>$request->serie,
    'MontantFact'       =>$request->MontantFact,
    'date_fact'         =>$request->date_fact,
    'payement'          =>$request->payement
  
  
  ]);
  
  // generation de token
  
  return response()->json([
    "statusCode"=>200,
    "status"    =>True,
    "Message"   =>"Felicitation vous venez de payer votre cours",
    "Facture"   =>$fact
  ],200);
  
  
  
    } catch (\Throwable $th) {
      //EPs
      return response()->json([
       "statuscode"=>500,
        "status"=>false,
        "message"=>$th->getMessage()
      ],500); 
    }
  }
  
  //affichage du status de la facture
  function afficher_facture(Request $request)
  {
      try {
        
              // code
              $StatusFact=Facture::all();
  
              //VDD
              return response()->json([
                  "statusCode"=>200,
                  "status"=>true,
                  "message"=>"f status effectué",
                  "Facture"=>$StatusFact
              ],200);
          } catch (\Throwable $th) {
              //EPs
              return response()->json([
                  "statusCode"=>500,
                  "status"=>False,
                  "message"=>$th->getMessage()
              ],500);
          }    
  }
  
  //affichage  de la facture par id
  
  function GetFacture_byId(Request $request){
    try {
  
      //code...
      $StatByID=Facture::firstwhere("idfactures",$request->idfactures)->First();
  
      //VDD
      return response()->json([
          "statusCode"=>200,
          "status"=>true,
          "message"=>"facture id effectué avec succès",
          "facture"=> $StatByID
      ],200);
  
  
    } catch (\Throwable $th) {
        //EPs
        return response()->json([
        "statusCode"=>500,
        "status"=>False,
        "message"=>$th->getMessage()
    ],500);
    }
  }
  
// modifier les factures (Admin)



function modifier_facture(Request $request)
{
    try {
        // Récupération des données de la requête
        $idfactures = $request->idfactures;
        $description_fact = $request->description_fact;

        // Code de modification
        $modiffact = Facture::where('idfactures', $idfactures)
            ->update(['description_fact' => $description_fact]);

        // Vérification
        if ($modiffact === 0) {
            return response()->json([
                "statusCode" => 400,
                "status" => false,
                "message" => 'Aucune modification effectuée'
            ]);
        } else {
            // Récupération de la facture modifiée (optionnel)
            $facture = Facture::find($idfactures);

            return response()->json([
                "statusCode" => 200,
                "status" => true,
                "message" => 'Modification effectuée avec succès',
                "facture" => $facture
            ], 200);
        }

    } catch (\Throwable $th) {
        // Gestion des erreurs
        return response()->json([
            "statusCode" => 500,
            "status" => false,
            "message" => $th->getMessage()
        ], 500);
    }
}


function supprimer_factureAD(Request $request)
{
    try {
        // Code...

      $fac =Facture::where('idfactures',$request->idfactures);

        if (!$fac) {
            return response()->json([
                "statusCode" => 404,
                "status" => false,
                "message" => "Facture non trouvée."
            ], 404);
        } else {
            $fac->delete();

            return response()->json([
                "statusCode" => 200,
                "status" => true,
                "message" => "Suppression effectuée avec succès",
                "Facture" => $fac
            ], 200);
        }

    } catch (\Throwable $th) {
        return response()->json([
            "statusCode" => 500,
            "status" => false,
            "message" => $th->getMessage()
        ], 500);
    }
}



/////////////////////
//ZONE SUPERVISION//
////////////////////

//ajouter une zone de supervision (admin)

function ajouterZone_sup(Request $request){
  try {
    //TDV (ville) admin
    $validateNum=validator::make($request->all(),[
      "ville"=>'required'
    ]);
//VDD

    if($validateNum->fails()){
      return response()->json([
        "statuscode"=>404,
        "status"    =>false,
        "Message"   =>"veillez entrer la ville actuelle ou vous habitez",
        "error"     =>$validateNum->errors()
      ],404);
    }


        //TDV (commune quartier) Admin
        $validateQC=validator::make($request->all(),[
          "commune_quartier"=>'required'
        ]);
    //VDD
    
        if($validateQC->fails()){
          return response()->json([
            "statuscode"=>404,
            "status"    =>false,
            "Message"   =>"veillez entrer la description de la facture",
            "error"     =>$validateQC->errors()
          ],404);
        }
    
        // creation d'une nouvelle zone

        $Zone=ZoneSupervision::create([
          'ville'       =>$request->ville,
          'commune_quartier'  =>$request->commune_quartier,

        ]);
  
        // generation de token
        
        return response()->json([
          "statusCode"=>200,
          "status"    =>True,
          "Message"   =>"Felicitation vous venez d'ajouter votre lieu de residence",
          "Zone"   =>$Zone
        ],200);

      } catch (\Throwable $th) {
        //EPs
        return response()->json([
         "statuscode"=>500,
          "status"=>false,
          "message"=>$th->getMessage()
        ],500); 
      }
    }


//affichage de la zone de supervision
 

function afficher_zoneSupAD(Request $request)
{
    try {
        // Code...

        $Zon = ZoneSupervision::all();

        // Vérification
        if ($Zon->isEmpty()) {
            return response()->json([
                'statusCode' => 404,
                'status' => false,
                'message' => 'Aucune zone de supervision disponible!'
            ], 404);
        } else {
            return response()->json([
                'statusCode' => 200,
                'status' => true,
                'message' => 'Zones de supervision affichées avec succès',
                'Zone de supervision' => $Zon
            ], 200);
        }

    } catch (\Throwable $th) {
        // Gestion des erreurs
        return response()->json([
            'statusCode' => 500,
            'status' => false,
            'message' => $th->getMessage()
        ], 500);
    }
}


// modifier les Zone supervision (Admin)

function modifier_ZoneSup(Request $request)
{
    try {
        //requete
        $idzone_supervision= $request->idzone_supervision;
        $ville= $request->ville;

        //code...
        $modifZon=ZoneSupervision::where('idzone_supervision',$idzone_supervision)->update(['idzone_supervision'=>$idzone_supervision,'ville'=>$ville]);

        //verification
        if($modifZon==0){
            return response()->json([
                "statusCode"=>400,
                "status"    =>false,
                "Message"   =>'aucune modification effectuée'
            ]);
        }else{
            return response()->json([
                "statusCode"=>200,
                "status"    =>true,
                "Message"   =>' modification effectuée avec succes',
                "Zone"      =>$modifZon
            ],200);  
        }

    } catch (\Throwable $th) {
        //EPs
        return response()->json([
            "statusCode"=>500,
            "status"=>false,
            "Message"=>$th->getMessage()
        ],500);
    }


}



// suppression de Zone supervision par identifiant (Admin)





function supprimer_ZoneSupAD(Request $request)
{
    try {
        // Code...

        $zone = ZoneSupervision::where('idzone_supervision', $request->idzone_supervision);

        if (!$zone) {
            return response()->json([
                "statusCode" => 404,
                "status" => false,
                "message" => "Zone de supervision non trouvée."
            ], 404);
        } else {
            $zone->delete();

            return response()->json([
                "statusCode" => 200,
                "status" => true,
                "message" => "Suppression effectuée avec succès",
                "zone" => $zone
            ], 200);
        }

    } catch (\Throwable $th) {
        return response()->json([
            "statusCode" => 500,
            "status" => false,
            "message" => $th->getMessage()
        ], 500);
    }
}









/////////////////////
//     CLASSE     //
////////////////////





function ajouter_classe(Request $request)
{
    try {
        // Validation du nom de la classe
        $validationNom = validator::make($request->all(), [
            "nom" => 'required'
        ]);

        // Vérification de la validation
        if ($validationNom->fails()) {
            return response()->json([
                "statusCode" => 404,
                "status" => false,
                "message" => "Veuillez entrer le nom de la classe",
                "error" => $validationNom->errors()
            ], 404);
        }

        // Validation du lieu
        $validationLieu = validator::make($request->all(), [
            "Lieu" => 'required'
        ]);

        // Vérification de la validation
        if ($validationLieu->fails()) {
            return response()->json([
                "statusCode" => 404,
                "status" => false,
                "message" => "Veuillez entrer le lieu de la rencontre du cours",
                "error" => $validationLieu->errors()
            ], 404);
        }

        // Validation de la commune ou du quartier
        $validationCommuneQuartier = validator::make($request->all(), [
            "commune_quartier" => 'required'
        ]);

        // Vérification de la validation
        if ($validationCommuneQuartier->fails()) {
            return response()->json([
                "statusCode" => 404,
                "status" => false,
                "message" => "Veuillez entrer la commune ou le quartier où la classe se situe",
                "error" => $validationCommuneQuartier->errors()
            ], 404);
        }

        // Création d'une nouvelle classe
        $classe = Classe::create([
            'nom' => $request->nom,
            'Lieu' => $request->Lieu,
            'commune_quartier' => $request->commune_quartier,
        ]);

        // Génération de token (s'il y a lieu)

        return response()->json([
            "statusCode" => 200,
            "status" => true,
            "message" => "Félicitations, vous venez d'ajouter une classe",
            "Classe" => $classe
        ], 200);

    } catch (\Throwable $th) {
        // Gestion des erreurs
        return response()->json([
            "statusCode" => 500,
            "status" => false,
            "message" => $th->getMessage()
        ], 500);
    }
}

//affichage de la classe
 

function getAll_classes(Request $request)
{
    try {
        // Code...

        $clas = Classe::all();

        // Vérification
        if ($clas->isEmpty()) {
            return response()->json([
                'statusCode' => 404,
                'status' => false,
                'message' => 'Aucune classe disponible!'
            ], 404);
        } else {
            return response()->json([
                'statusCode' => 200,
                'status' => true,
                'message' => 'Classe affichées avec succès',
                'Classe' => $clas
            ], 200);
        }

    } catch (\Throwable $th) {
        // Gestion des erreurs
        return response()->json([
            'statusCode' => 500,
            'status' => false,
            'message' => $th->getMessage()
        ], 500);
    }
}


// modifier les classe (Admin)

function update_classes(Request $request)
{
    try {
        //requete
        $idclasses= $request->idclasses;
        $Lieu= $request->Lieu;

        //code...
        $modifclas=Classe::where('idclasses',$idclasses)->update(['idclasses'=>$idclasses,'Lieu'=>$Lieu]);

        //verification
        if($modifclas==0){
            return response()->json([
                "statusCode"=>400,
                "status"    =>false,
                "Message"   =>'aucune modification effectuée'
            ]);
        }else{
            return response()->json([
                "statusCode"=>200,
                "status"    =>true,
                "Message"   =>' modification effectuée avec succes',
                "classe"      =>$modifclas
            ],200);  
        }

    } catch (\Throwable $th) {
        //EPs
        return response()->json([
            "statusCode"=>500,
            "status"=>false,
            "Message"=>$th->getMessage()
        ],500);
    }


}



// suppression de classe par identifiant (Admin)


function delete_classes(Request $request)
{
    try {
        // Code...

        $class = Classe::Where('idclasses', $request->idclasses);

        if (!$class) {
            return response()->json([
                "statusCode" => 404,
                "status" => false,
                "message" => "Classe non trouvée."
            ], 404);
        } else {
            $class->delete();

            return response()->json([
                "statusCode" => 200,
                "status" => true,
                "message" => "Suppression effectuée avec succès",
                "Classe" => $class
            ], 200);
        }

    } catch (\Throwable $th) {
        return response()->json([
            "statusCode" => 500,
            "status" => false,
            "message" => $th->getMessage()
        ], 500);
    }
}


/////////////////////
//    MAtiere   //
////////////////////


function ajouter_matiere(Request $request){
    try {
        //TDV (nom matiere)
        $validateNom=validator::make($request->all(),[
            "nom_mat"=>"required",
        ]);
        if($validateNom->fails()){
            return response()->json([
                "statusCode"=>404,
                "status"    =>false,
                "Message"   =>"veillez entrer le nom de la matiere"
            ],404);
        }

        /**Ajout de matiere */

        $mat=Matiere::create([
            "nom_mat"  => $request->nom_mat
        ]);

  // generation de token
  
  return response()->json([
    "statusCode"=>200,
    "status"    =>True,
    "Message"   =>"Felicitation vous avez ajouter un nouveau",
    "Facture"   =>$mat
  ],200);



    } catch (\Throwable $th) {
        //EPs
        return response()->json([
            "statusCode"=>500,
            "status"    =>false,
            "error"   =>$th->getMessage()
        ],500);
    }
}

// affichage des cour (Admin)

function getMatiere(Request $request)
{
    try {
        // Code...

        $Mat = Matiere::all();

        // Vérification
        if ($Mat->isEmpty()) {
            return response()->json([
                'statusCode' => 404,
                'status' => false,
                'message' => 'Aucune Matiere disponible!'
            ], 404);
        } else {
            return response()->json([
                'statusCode' => 200,
                'status' => true,
                'message' => 'Matiere affichées avec succès',
                'Matiere' => $Mat
            ], 200);
        }

    } catch (\Throwable $th) {
        // Gestion des erreurs
        return response()->json([
            'statusCode' => 500,
            'status' => false,
            'message' => $th->getMessage()
        ], 500);
    }
}


// modification des cour (Admin)





function updateMatiere(Request $request)
{
    try {
        // Récupération des données de la requête
        $idmatiere = $request->idmatiere;
        $nom_mat = $request->nom_mat;

        // Mise à jour de la matière
        $modifMat = Matiere::where('idmatiere', $idmatiere)->update(['idmatiere'=> $idmatiere,'nom_mat' => $nom_mat]);

        // Vérification si la mise à jour a eu lieu
        if ($modifMat == 0) {
            return response()->json([
                "statusCode" => 400,
                "status" => false,
                "message" => 'Aucune modification effectuée'
            ]);
        } else {
            // Réponse JSON avec les détails de la mise à jour
            return response()->json([
                "statusCode" => 200,
                "status" => true,
                "message" => 'Modification effectuée avec succès',
                "matiere" => $modifMat
            ], 200);
        }

    } catch (\Throwable $th) {
        // Gestion des erreurs
        return response()->json([
            "statusCode" => 500,
            "status" => false,
            "message" => $th->getMessage()
        ], 500);
    }
}




// suppression de classe par identifiant (Admin)




function deleteMatiere(Request $request)
{
    try {
        // Récupération de la matière par son ID
        $matiere = Matiere::where('idmatiere', $request->idmatiere);

        // Vérification si la matière a été trouvée
        if (!$matiere) {
            return response()->json([
                "statusCode" => 404,
                "status" => false,
                "message" => "Matiere non trouvée."
            ], 404);
        } else {
            // Suppression de la matière
            $matiere->delete();

            return response()->json([
                "statusCode" => 200,
                "status" => true,
                "message" => "Suppression effectuée avec succès",
                "Matiere" => $matiere
            ], 200);
        }

    } catch (\Throwable $th) {
        // Gestion des erreurs
        return response()->json([
            "statusCode" => 500,
            "status" => false,
            "message" => $th->getMessage()
        ], 500);
    }
}

//affichage des MATIERE par l'id

function MatbyId(Request $request){
    try {
      //code...
  $MAtById=Matiere::firstwhere('idmatiere',$request->idmatiere);
  
  return response()->json([
    "statusCode"=>200,
    "status"=>true,
    "message"=>"affichage effectué avec succès",
    "Matiere"=>$MAtById
  ],200);
  
    } catch (\Throwable $th) {
        //EPs
        return response()->json([
          "statusCode"=>500,
          "status"=>False,
          "message"=>$th->getMessage()
      ],500);
    }
  }







}
