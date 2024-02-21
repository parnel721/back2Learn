<?php

namespace App\Http\Controllers;
use App\Models\Matiere;
use Illuminate\Http\Request;

class MatiereController extends Controller
{
        //affichage des matiere
 

function afficher_matiere(Request $request)
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

}
