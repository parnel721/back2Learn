<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Eleve;
use App\Models\Facture;
use App\Models\Cour;
use App\Models\Classe;
use App\Models\Matiere;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;


class ELevesController extends Controller
{
    //////////////////////////////////////////
    //-----------CRUD ELEVES-----------------*
    //////////////////////////////////////////
    //////////////////////////////////////////


    // NB: signification des accronymes suivants

    //TDV : Traitement des données avec validator
    //VDD : Verification des données 
    //EPs : permet de cibler une erreur provenant du serveur

/*-----------------------
/**Authentification */
//-----------------------


/**** 
//Inscriptions eleves//
***/

function inscription_eleves (Request $request){

  try {
    // Traitement des données avec validator (nom)
    $validateNom= validator::make($request->all(),[
        'nom'=>'required|min:3'
    ]);

    // Verification des données 
    if( $validateNom->fails()){
      return response()->json([
        "StatusCode"=>404,
        "status"=>false,
        "message"=>'veillez saisir votre nom',
        "errors"=>$validateNom->errors()
      ],404); 
    }


    // Traitement des données avec validator (prenom)
    $validatePrenom= validator::make($request->all(),[
      'nom'=>'required|min:3'
  ]);

  // Verification des données 
  if( $validatePrenom->fails()){
    return response()->json([
      "StatusCode"=>404,
      "status"=>false,
      "message"=>'veillez saisir votre prenom',
      "errors"=>$validatePrenom->errors()
    ],404); 
  }

  //traitement des données avec validator (Date_naissance)
  
  $validateDateNaiss=validator::make($request->all(),[
    "date_naissance"=>'required'
  ]);

  //verification des données 
  if ($validateDateNaiss->fails()){
    return response()->json([
      "statuscode"=>404,
      "status"=>false,
      "Message"=>'veillez entrer votre date de naissance',
      "errors"=>$validateDateNaiss->errors()
    ],404);
  }

  //traitement des données avec validator (Telephone)
  
  $validateTel=validator::make($request->all(),[
    "Telephone"=>'required|min:10'
  ]);

  //verification des données 
  if ($validateTel->fails()){
    return response()->json([
      "statuscode"=>404,
      "status"=>false,
      "Message"=>'veillez entrer votre numero de telephone',
      "errors"=>$validateTel->errors()
    ],404);
  }

  //traitement des données avec validator (Email)
  
  $validateMail=validator::make($request->all(),[
    "email"=>'required'
  ]);

  //verification des données 
  if ($validateMail->fails()){
    return response()->json([
      "statuscode"=>404,
      "status"=>false,
      "Message"=>'veillez entrer votre E-mail',
      "errors"=>$validateMail->errors()
    ],404);
  }

    //traitement des données avec validator (password)
  
    $validatePass=validator::make($request->all(),[
      "password"=>'required'
    ]);
  
    //verification des données 
    if ($validatePass->fails()){
      return response()->json([
        "statuscode"=>404,
        "status"=>false,
        "Message"=>'veillez entrer votre mot de pase',
        "errors"=>$validatePass->errors()
      ],404);
    }
  
      //traitement des données avec validator (Niveau)
  
      $validateLevel=validator::make($request->all(),[
        "niveau"=>'required'
      ]);
    
      //verification des données 
      if ($validateLevel->fails()){
        return response()->json([
          "statuscode"=>404,
          "status"=>false,
          "Message"=>'veillez entrer votre niveau',
          "errors"=>$validateLevel->errors()
        ],404);
      }
    
      //traitement des données avec validator (serie)
  
      $validateSerie=validator::make($request->all(),[
        "serie"=>'required'
      ]);
    
      //verification des données 
      if ($validateSerie->fails()){
        return response()->json([
          "statuscode"=>404,
          "status"=>false,
          "Message"=>'veillez entrer votre serie',
          "errors"=>$validateSerie->errors()
        ],404);
      }

      //traitement des données avec validator (nom_parent)

      $validateParent=validator::make($request->all(),[
        "nom_parent"=>'required|min:3'
      ]);
    
      //verification des données 
      if ($validateParent->fails()){
        return response()->json([
          "statuscode"=>404,
          "status"=>false,
          "Message"=>'veillez entrer le nom de l\'un de votre parent',
          "errors"=>$validateParent->errors()
        ],404);
      }

      //traitement des données avec validator (Contact_parent)

      $validatePcontact=validator::make($request->all(),[
        "contact_parent"=>'required|max:10'
      ]);
    
      //verification des données 
      if ($validatePcontact->fails()){
        return response()->json([
          "statuscode"=>404,
          "status"=>false,
          "Message"=>'veillez entrer le contact de l\'un de votre parent',
          "errors"=>$validatePcontact->errors()
        ],404);
      }

      //traitement des données avec validator (Emploi_du_Temps)

      $validateEmploi=validator::make($request->all(),[
        "contact_parent"=>'required'
      ]);
    
      //verification des données 
      if ($validateEmploi->fails()){
        return response()->json([
          "statuscode"=>404,
          "status"=>false,
          "Message"=>'veillez entrer vos jours de disponibilité afin que nous concevons votre emploi du temps',
          "errors"=>$validateEmploi->errors()
        ],404);
      }

      /////////////////////////////
      // OUVERTURE D'UN COMPTE//
      /////////////////////////////

      $user= User::create([
        'telephone' => $request->Telephone,
      ]);

      $Eleves=Eleve::create([

        "nom"             =>$request->nom,
        "prenom"          =>$request->prenom,
        "date_naissance"  =>$request->date_naissance,
        "Telephone"       =>$request->Telephone,
        "email"           =>$request->email,
        "password"        =>$request->password,
        "niveau"          =>$request->niveau,
        "serie"           =>$request->serie,
        "nom_parent"      =>$request->nom_parent,
        "contact_parent"  =>$request->contact_parent,
        "emploi_du_temps" =>$request->emploi_du_temps,
        'id_users'        =>$user->id,
        
      ]);

      /////////////////////////////
        // GENERATION DE TOKEN//
      /////////////////////////////

      return response()->json([
        "statuscode"=>200,
        "status"    =>true,
        "Message"   =>"votre compte est ouvert avec success",
        "Eleves"    =>$Eleves,
        'token'     => $user->createToken("API TOKEN")->plainTextToken
      ],200);

  } catch (\Throwable $th)
  //permet de cibler une erreur provenant du serveur
  {
    return response()->json([
      "statusCode"=>500,
      "status"=>false,
      "Message"=>$th->getMessage()
    ],500);
  }
}

/**** 
//connexion eleves//
***/
function connexion_eleves (Request $request)
{
try {

  // Traitement des donnée avec validator (Telephone)

  $validateTel=validator::make($request->all(),[
    "Telephone"=>'required|min:10'
  ]);

  //Verification des données
  if($validateTel->fails()){
    return response()->json([
      'statuscode'=>401,
      'status'    =>false,
      "Message"   =>"veillez entrer votre numero de telephone",
      "errors"    =>$validateTel->errors()
    ],401);
  }

   // Traitement des donnée avec validator (Password)

  $validatePass=validator::make($request->all(),[
    "password"=>'required'
  ]);

  //Verification des données
  if($validatePass->fails()){
    return response()->json([
      'statuscode'=>404,
      'status'    =>false,
      "Message"   =>"veillez entrer votre Mot de passe",
      "errors"    =>$validatePass->errors()
    ],404);
  }

//////////////////////////////
  // NOUVELLE CONNEXION //
/////////////////////////////

        // verification de la connexion  
        $login = Eleve::firstWhere('Telephone',$request->Telephone);
        if ($login) {
            $user = User::firstWhere('telephone', $request->Telephone)->first();
            return response()->json([
                "statuscode"=>200,
                "status"    =>true,
                "message"   =>"connecté avec succès",
                "patient"   =>$login,
                "Token"     =>$user->CreateToken("API TOKEN")->plainTextToken
             ],200);
        }else{
            return response()->json
            ([
                "statuscode"=>401,
                "status"=>false,
                "message"=>" telephone incorrecte",
                "compte"=>[],
             ],401);
        }
} catch (\Throwable $th) {
// permet de cibler une erreur provenant du serveur...

  return response()->json([
    "statuscode"=>500,
    "status"    =>false,
    "message"   =>$th->getMessage()
  ],500);
}

}

/**** 
//Generer otp//
***/

function generer_otp(Request $request){
  return 'hello';
}


/**** 
//Verifier otp//
***/
function verifier_otp(Request $request){
  return 'hello';
}


/*-----------------------
      /**COMPTES */
//-----------------------

/**** 
//afficher compte Eleves//
***/
function afficher_compte(Request $request){
  try {
    $getELev=Eleve::all();

    if (count($getELev)!==0){
      return response()->json([
        "statuscode"=>200,
        "status"    =>true,
        "Message"   =>'affichage du compte avec succès',
        "compte"    =>$getELev
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


/**** 
//modififié compte Eleves//
***/


function update_compte(Request $request){

  try {

    // poser une requete
    $ideleves =  $request->ideleves ;
    $nom      =  $request->nom;
    
    // code 
   
    $updatCompt=Eleve::where('ideleves',$ideleves)->update(["ideleves"=>$ideleves ,"nom"=>$nom]);

    //VDD

    if($updatCompt==0){
      return response()->json([
        "statuscode"=>404,
        "status"    =>false,
        "message"   =>'aucune modification effectué'
      ],404);
    }else{

      return response()->json([
        "statusCode"=>200,
        "status" =>true,
        "message"=>"modification  effectué avec succes",
        "compte"=>$updatCompt
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






/*-----------------------
      /**FACTURES */
//-----------------------

//affichage du status de la facture
function afficher_status_facture(Request $request)
{
    try {
      
            // code
            $StatusFact=Facture::firstwhere("payement",$request->payement);

            //VDD
            return response()->json([
                "statusCode"=>200,
                "status"=>true,
                "message"=>"ordonnance status effectué",
                "ordonnance"=>$StatusFact
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

function status_by_id(Request $request){
  try {

    //code...
    $StatByID=Facture::firstwhere("idfactures",$request->idfactures);

    //VDD
    return response()->json([
        "statusCode"=>200,
        "status"=>true,
        "message"=>"ordonnance id effectué",
        "ordonnance"=> $StatByID
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


/*-----------------------
      /**COURS */
//-----------------------

//affichage de la totalité des cours

function afficher_cours(Request $request){
    try {

      //code...
      $Cours=Cour::all();

      //VDD
      if($Cours==0){
        return response()->json([
          'statuscode'=>404,
          'status'    =>false,
          'Message'   =>'aucun cours disponible!'
        ],404);
      }else{
        return response()->json([
          "statuscode"=>200,
          "status"    =>false,
          'Message'   =>"Cours affichés avec succès",
          "cour"      =>$Cours
        ],200);
      }

    } catch (\Throwable $th) {
      //EPs
      return response()->json([
        "statusCode"=>500,
        "status"=>False,
        "message"=>$th->getMessage()
    ],500);
    }
}

//affichage des cours par l'id

function afficherCours_Matiere(Request $request){
  try {
    //code...
$courById=Cour::firstwhere('id',$request->cours_idcours);

return response()->json([
  "statusCode"=>200,
  "status"=>true,
  "message"=>"affichage effectué avec succès",
  "ordonnance"=>$courById
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



/*-----------------------
      /**CLASSES */
//-----------------------

//affichage du lieu d'enseignement

function afficher_classe(Request $request){
  try {

    //code...
    $Classe=Classe::all();

    //VDD
    if($Classe==0){
      return response()->json([
        'statuscode'=>404,
        'status'    =>false,
        'Message'   =>'aucune Classe disponible!'
      ],404);
    }else{
      return response()->json([
        "statuscode"=>200,
        "status"    =>false,
        'Message'   =>"classe affichés avec succès",
        "cour"      =>$Classe
      ],200);
    }

  } catch (\Throwable $th) {
    //EPs
    return response()->json([
      "statusCode"=>500,
      "status"=>False,
      "message"=>$th->getMessage()
  ],500);
  }
}





/*-----------------------
      /**MATIERES */
//-----------------------


//affichage des matieres constituant un cours

function afficher_Matiere(Request $request){
  try {

    //code...
    $Mat=Matiere::all();

    //VDD
    if($Mat==0){
      return response()->json([
        'statuscode'=>404,
        'status'    =>false,
        'Message'   =>'aucune Matiere disponible!'
      ],404);
    }else{
      return response()->json([
        "statuscode"=>200,
        "status"    =>false,
        'Message'   =>"Matiere affichés avec succès",
        "cour"      =>$Mat
      ],200);
    }

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
