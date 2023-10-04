<?php

namespace App\Http\Controllers\Gestionnaire;

use App\Models\Marque;
use App\Models\Modele;
use Illuminate\Support\Str;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class MarqueController extends Controller
{
    public function getMarqueVoiture()
    {
        $marques = DB::table('marques')
            ->select('marques.*', 'users.*')
            ->join('users', 'users.id', '=', 'marques.created_by')
            ->orderByDesc('marques.created_at')
            ->get();
        return view('packages.marques.gestionnaire.marque', compact('marques'));
    }

    public function infoMarque(Request $request)
    {
        $marque = Marque::where('id_marque', decodeId($request->id_marque))
            ->select('marques.*', 'users.*')
            ->join('users', 'users.id', '=', 'marques.created_by')
            ->orderByDesc('marques.created_at')
            ->first();
        return response()->json($marque);
    }

    public function getSpecMarqueVoiture(Request $request)
    {
        $modele = Modele::where('marque_id', decodeId($request->marque_id))->get();
        return response()->json($modele);
    }

    public function loadDataMarque(Request $request)
    {
        if ($request->ajax()) {
        }
    }

    public function storeMarqueVoiture(Request $request)
    {
        $messages = [
            "nom_marque.required" => "Le nom de la marque est requis",
            "nom_marque.max" => "Le nom de la marque est trop long",
            "nom_marque.unique" => "Cette marque existe deja dans le système",
        ];

        $validator = Validator::make($request->all(), [
            "nom_marque" => "bail|required|max:100|unique:marques,nom_marque",
        ], $messages);

        if ($validator->fails()) return response()->json([
            "status" => false,
            "reload" => false,
            "redirect_to" => null,
            "title" => "ENREGISTREMENT DE LA MARQUE",
            "message" => $validator->errors()->first(),
        ]);

        $marque = new Marque();
        $marque->nom_marque = $request->nom_marque;
        $marque->code_marque = "MARQUE-" . generateToken(6, DIGIT_TOKEN);
        $marque->slug_marque = Str::slug("marque-" . $request->nom_marque);
        $marque->status_marque = true;
        $marque->created_by = Auth::id();
        $process = $marque->save();

        //Enregistrement du systeme de log
        if ($process) saveSysActivityLog(SYS_LOG_SUCCESS, "Enregistrement de la marque " . $marque->nom_marque . " avec succes dans le système.", Auth::id());
        else saveSysActivityLog(SYS_LOG_ERROR, "Echec d'enregistrement de la marque " . $marque->nom_marque . " avec succes dans le système.", Auth::id());

        return response()->json([
            "status" => true,
            "reload" => false,
            "redirect_to" => null,
            "title" => "ENREGISTREMENT DE LA MARQUE",
            "message" => "La marque " . $marque->nom_marque . " a été ajoutée avec succes"
        ]);
    }

    public function updateMarqueVoiture(Request $request)
    {
        $messages = [
            "nom_marque.required" => "Le nom de la marque est requis",
            "nom_marque.max" => "Le nom de la marque est trop long",
        ];

        $validator = Validator::make($request->all(), [
            "nom_marque" => "bail|required|max:100",
        ], $messages);

        if ($validator->fails()) return response()->json([
            "status" => false,
            "reload" => false,
            "title" => "MISE A JOUR DE LA MARQUE",
            "message" => $validator->errors()->first(),
        ]);

        $marque = Marque::findOrFail($request->id_marque);
        $marque->nom_marque = $request->nom_marque;
        $marque->slug_marque = Str::slug($request->nom_marque);
        $marque->status_marque = $request->status_marque;
        $process = $marque->save();

        //Enregistrement du systeme de log
        if ($process) saveSysActivityLog(SYS_LOG_SUCCESS, "Mise à jour de la marque " . $marque->nom_marque . " avec succes dans le système.", Auth::id());
        else saveSysActivityLog(SYS_LOG_ERROR, "Echec de mise à jour de la marque " . $marque->nom_marque . " avec succes dans le système.", Auth::id());

        return response()->json([
            "status" => $process,
            "reload" => false,
            "title" => "MISE A JOUR DE LA MARQUE",
            "message" => "La marque " . $marque->nom_marque . " a été mise à jour avec succes"
        ]);
    }

    public function deleteMarqueVoiture(Request $request)
    {
        $marque = Marque::findOrFail($request->id_marque);
        $process = $marque->delete();

        //Enregistrement du systeme de log
        if ($process) saveSysActivityLog(SYS_LOG_SUCCESS, "Suppression de la marque " . $marque->nom_marque . " dans le système", Auth::id());
        else saveSysActivityLog(SYS_LOG_SUCCESS, "Echec de suppression de la marque " . $marque->nom_marque . " dans le système", Auth::id());

        return response()->json([
            "status" => $process,
            "reload" => true,
            "title" => "SUPPRESSION DE LA MARQUE",
            "message" => "La marque " . $marque->nom_marque . " a été bien supprimé dans le système"
        ]);
    }
}
