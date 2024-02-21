<?php

namespace App\Http\Controllers;
use App\Models\ZoneSupervision;
use Illuminate\Http\Request;

class ZoneSupController extends Controller
{
    
    //affichage de la zone de supervision
 

function afficher_zone(Request $request)
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

 
  //affichage  de la Zone de supervision par id
  


  function zoneById(Request $request)
  {
      try {
          // Récupération de la zone de supervision par ID
          $zone = ZoneSupervision::where('idzone_supervision', $request->idzone_supervision)->first();
  
          // Vérification si la zone a été trouvée
          if (!$zone) {
              return response()->json([
                  "statusCode" => 404,
                  "status" => false,
                  "message" => "Zone de supervision non trouvée."
              ], 404);
          } else {
              // Réponse JSON avec la zone trouvée
              return response()->json([
                  "statusCode" => 200,
                  "status" => true,
                  "message" => "Zone ID effectué avec succès",
                  "zone" => $zone
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
  












}
