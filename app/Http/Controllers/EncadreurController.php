<?php

namespace App\Http\Controllers;
// importation des models

use App\Models\Encadreur;
use App\Models\User;
use Illuminate\Support\Facades\Validator;






use Illuminate\Http\Request;

class EncadreurController extends Controller
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
//

//inscription de l'encadreur

function inscription_encadreur(Request $request){

    try {
        //TDV (nom encadreur)
        $validateNom= validator::make($request->all(),[
            'nom'=>'required|min:3'
        ]);
        if ($validateNom->fails()){
            return response()->json([
            "statuscode"=>404,
            "status"    =>false,
            "Message"   =>'veillez entrer votre nom',
            "errors"    =>$validateNom->errors()

            ]);
        }

        //TDV (Prenom encadreur)
        $validatePren= validator::make($request->all(),[
            'prenom'=>'required|min:3'
        ]);
        if ($validatePren->fails()){
            return response()->json([
            "statuscode"=>404,
            "status"    =>false,
            "Message"   =>'veillez entrer votre prenom',
            "errors"    =>$validatePren->errors()

            ]);
        }

        //TDV (dte_naissance encadreur)
        $validateDte= validator::make($request->all(),[
            'date_naissance'=>'required'
        ]);
        if ($validateDte->fails()){
            return response()->json([
            "statuscode"=>404,
            "status"    =>false,
            "Message"   =>'veillez entrer votre date de naissance',
            "errors"    =>$validateDte->errors()

            ]);
        }


        //TDV (Telephone encadreur)
        $validateTel= validator::make($request->all(),[
            'Telephone'=>'required'
        ]);
        if ($validateTel->fails()){
            return response()->json([
            "statuscode"=>404,
            "status"    =>false,
            "Message"   =>'veillez entrer votre Telephone',
            "errors"    =>$validateTel->errors()

            ]);
        }


        

       //TDV (email encadreur)
       $validatemail= validator::make($request->all(),[
        'email'=>'required'
    ]);
    if ($validatemail->fails()){
        return response()->json([
        "statuscode"=>404,
        "status"    =>false,
        "Message"   =>'veillez entrer votre E-mail',
        "errors"    =>$validatemail->errors()

        ]);
    }

       //TDV (password encadreur)
       $validatPwd= validator::make($request->all(),[
        'password'=>'required'
    ]);
    if ($validatPwd->fails()){
        return response()->json([
        "statuscode"=>404,
        "status"    =>false,
        "Message"   =>'veillez entrer votre mot de passe',
        "errors"    =>$validatPwd->errors()

        ]);
    }

       //TDV (profession encadreur)
       $validatPf= validator::make($request->all(),[
        'profession'=>'required'
    ]);
    if ($validatPf->fails()){
        return response()->json([
        "statuscode"=>404,
        "status"    =>false,
        "Message"   =>'veillez entrer votre profession',
        "errors"    =>$validatPf->errors()

        ]);
    }


       //TDV (diplome encadreur)
       $validatDp= validator::make($request->all(),[
        'diplome'=>'required'
    ]);
    if ($validatDp->fails()){
        return response()->json([
        "statuscode"=>404,
        "status"    =>false,
        "Message"   =>'veillez entrer votre diplome',
        "errors"    =>$validatDp->errors()

        ]);
    }

       //TDV (cni encadreur)
       $validatCni= validator::make($request->all(),[
        'cni'=>'required'
    ]);
    if ($validatCni->fails()){
        return response()->json([
        "statuscode"=>404,
        "status"    =>false,
        "Message"   =>'veillez entrer votre CNI',
        "errors"    =>$validatCni->errors()

        ]);
    }


       //TDV (Ville encadreur)
       $validatVil= validator::make($request->all(),[
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


       //TDV (commune_quatier encadreur)
       $validatC_Q= validator::make($request->all(),[
        'commune_quatier'=>'required'
    ]);
    if ($validatC_Q->fails()){
        return response()->json([
        "statuscode"=>404,
        "status"    =>false,
        "Message"   =>'veillez entrer votre commune ou quatier',
        "errors"    =>$validatC_Q->errors()

        ]);
    }

      /////////////////////////////
      // OUVERTURE D'UN COMPTE//
      /////////////////////////////

      $user= User::create([
        'telephone' => $request->Telephone,
      ]);

      $encadreur=Encadreur::create([
            "nom"                   =>$request->nom,
            "prenom"                =>$request->prenom,
            "date_naissance"        =>$request->date_naissance,
            "Telephone"             =>$request->Telephone,
            "email"                 =>$request->email,
            "password"              =>$request->password,
            "profession"            =>$request->profession,
            "diplome"               =>$request->diplome,
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
        "Message"   =>" Félicitation votre compte est ouvert avec success",
        "Eleves"    =>$encadreur,
        'token'     => $user->createToken("API TOKEN")->plainTextToken
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


// connexion au compte de l'encadreur

function connexion_encadreur(Request $request){
    
    try {
        //TDV
        $validateTel=validator::make($request->all(),[
            "Telephone"=>'required'
        ]);
        
        if ($validateTel->fails()){
            return response()->json([
            "statuscode"=>404,
            "status"    =>false,
            "Message"   =>'veillez entrer votre numero de telephone',
            "errors"    =>$validateTel->errors()
    
            ]);
        }

        ////////////////////////
        ///nouvelle connexion //
        ///////////////////////

        $encad=Encadreur::firstWhere('Telephone',$request->Telephone);
        if($encad)
        {
            $user = User::firstWhere('telephone', $request->Telephone)->first();
            return response()->json([
                "statuscode"=>200,
                "status"    =>true,
                "message"   =>"connecté avec succès",
                "patient"   =>$encad,
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
        //EPs
        return response()->json([
            "statuscode"=>500,
            "status"    =>false,
            "Message"   =>$th->getMessage()
        ],500);

    }

}


//generer otp (Encadreur)
function generer_otp(Request $request){

}

//verifier otp (Encadreur)
function Verifier_otp(Request $request){
    
}


//////////////////////
///COMPTE ENCADREUR//
////////////////////

//afficher les informations de l'encadreur

function afficher_compte(Request $request){

    try {
        $Encadreur=Encadreur::all();
    
        if (count($Encadreur)!==0){
          return response()->json([
            "statuscode"=>200,
            "status"    =>true,
            "Message"   =>'affichage du compte avec succès',
            "compte"    =>$Encadreur
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

function update_compte(Request $request){

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



















}
