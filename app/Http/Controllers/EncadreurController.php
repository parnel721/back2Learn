<?php

namespace App\Http\Controllers;
// importation des models
use App\Models\Cour;
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
        $validateDte=validator::make($request->all(),[
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
        $validateTel=validator::make($request->all(),[
            'Telephone'=>'required|min:10|unique:encadreurs'
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
       $validatemail=validator::make($request->all(),[
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
       $validatPwd=validator::make($request->all(),[
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
       $validatPf=validator::make($request->all(),[
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
       $validatDp=validator::make($request->all(),[
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
       $validatCni=validator::make($request->all(),[
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


       //TDV (commune_quatier encadreur)
       $validatC_Q=validator::make($request->all(),[
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
        'telephone' =>$request->Telephone,
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
        "Message"   =>"Félicitation votre compte est ouvert avec success",
        "Encadreur"    =>$encadreur,
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


// connexion au compte de l'encadreur

public function connexion_encadreur(Request $request){
    try {
        // Traitement des données avec Validator
        $validator = Validator::make($request->all(), [
            "Telephone" =>'required|min:10'
        ]);

        // Vérification des données
        if ($validator->fails()) {
            return response()->json([
                "statuscode" =>404,
                "status"     =>false,
                "message"    =>'Veuillez fournir votre numéro de téléphone',
                "errors"     =>$validator->errors()
            ]);
        }

        // Nouvelle connexion
        $encadreur = Encadreur::firstWhere('Telephone', $request->Telephone);

        if ($encadreur) {
            $user = User::firstWhere('telephone', $request->Telephone)->firstOrFail();
            return response()->json([
                "statuscode" =>200,
                "status"     =>true,
                "message"    =>"Connecté avec succès",
                "encadreur"  =>$encadreur,
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




  
//////////////////////
    ///COURS //
////////////////////

// ajouter les cours (Encadreur)
function add_cours (Request $request){

    try {
      // Traitement des données avec validator (cours typ)
      $validateTyp= validator::make($request->all(),[
          'type_cours'=>'required|min:3'
      ]);
  
      // Verification des données 
      if( $validateTyp->fails()){
        return response()->json([
          "StatusCode"=>404,
          "status"=>false,
          "message"=>'veillez saisir votre type de cours',
          "errors"=>$validateTyp->errors()
        ],404); 
      }
  
  
      // Traitement des données avec validator (prix de cours)
      $validatePrix= validator::make($request->all(),[
        'prix_cours'=>'required|min:3'
    ]);
  
    // Verification des données 
    if( $validatePrix->fails()){
      return response()->json([
        "StatusCode"=>404,
        "status"=>false,
        "message"=>'veillez saisir votre prix',
        "errors"=>$validatePrix->errors()
      ],404); 
    }
  
    //traitement des données avec validator (emploi du temps)
    
    $validateEMP=validator::make($request->all(),[
      "emploi_du_temps"=>'required'
    ]);
  
    //verification des données 
    if ($validateEMP->fails()){
      return response()->json([
        "statuscode"=>404,
        "status"=>false,
        "Message"=>'veillez entrer votre Emploi du temps',
        "errors"=>$validateEMP->errors()
      ],404);
    }
  
        //traitement des données avec validator (horaire)
    
        $validateHoraire=validator::make($request->all(),[
            "horaire"=>'required'
          ]);
        
          //verification des données 
          if ($validateHoraire->fails()){
            return response()->json([
              "statuscode"=>404,
              "status"=>false,
              "Message"=>'veillez entrer votre Emploi du temps',
              "errors"=>$validateHoraire->errors()
            ],404);
          }
   
  
        /////////////////////////////
        // OUVERTURE D'UN COMPTE//
        /////////////////////////////
  

  
        $Cours=Cour::create([
  
          "type_cours"      =>$request->type_cours,
          "prix_cours"      =>$request->prix_cours,
          "emploi_du_temps" =>$request->emploi_du_temps,
          "horaire"         =>$request->horaire
         

        ]);
  
        // ////////////////////////////////////
        //   // aucune  GENERATION DE TOKEN//
        // ///////////////////////////////////
  
        return response()->json([
          "statuscode"=>200,
          "status"    =>true,
          "Message"   =>"votre compte est ouvert avec success",
          "cours"    =>$Cours,
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
  




// visionner les cours (Encadreur)


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

  

// modifier les cours (Encadreur)

function update_cours(Request $request)
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
                "Message"   =>' modification effectuée avec succes'
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

//affichage des cours par l'id



function cours_by_id(Request $request){
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



// suppression de cours par identifiant (Encadreur)

function suppression_cours(Request $request){
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










}
