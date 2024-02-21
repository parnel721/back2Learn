<?php

namespace App\Http\Controllers;
use App\Models\Classe;
use Illuminate\Http\Request;

class ClasseController extends Controller
{
    
    function afficher_classe(Request $request)
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

}
