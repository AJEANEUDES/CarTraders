<?php

namespace App\Http\Controllers\Gestionnaire;

use App\Models\Marque;
use App\Models\Modele;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class ModeleController extends Controller
{
    public function getModeleVoiture()
    {
        $marques = Marque::where('status_marque', true)->orderByDesc('created_at')->get();

        $modeles = Modele::select('modeles.*', 'marques.*')
            ->join('marques', 'marques.id_marque', '=', 'modeles.marque_id')
            ->orderByDesc('modeles.created_at')
            ->get();
        return view('packages.modeles.gestionnaire.modele', compact(['modeles', 'marques']));
    }

    public function infoModele(Request $request)
    {
        $modele = Modele::where('id_modele', decodeId($request->id_modele))
            ->select('modeles.*', 'marques.*', 'users.*')
            ->join('marques', 'marques.id_marque', '=', 'modeles.marque_id')
            ->join('users', 'users.id', '=', 'modeles.created_by')
            ->orderByDesc('modeles.created_at')
            ->first();
        return response()->json($modele);
    }

    public function storeModeleVoiture(Request $request)
    {
        $messages = [
            "nom_modele.required" => "Le nom du modele est requis",
            "nom_modele.max" => "Le nom du modele est trop long",
            "nom_modele.unique" => "Ce modele existe deja dans le système",
            "marque_id.required" => "La marque du modele est requise",
        ];

        $validator = Validator::make($request->all(), [
            "nom_modele" => "bail|required|max:50|unique:modeles,nom_modele",
            "marque_id" => "bail|required",
        ], $messages);

        if ($validator->fails()) return response()->json([
            "status" => false,
            "reload" => false,
            "redirect_to" => null,
            "title" => "ENREGISTREMENT DU MODELE",
            "message" => $validator->errors()->first(),
        ]);

        $modele = new Modele();
        $modele->nom_modele = $request->nom_modele;
        $modele->code_modele = "MODELE-" . generateToken(6, DIGIT_TOKEN);
        $modele->slug_modele = Str::slug("modele-" . $request->nom_modele);
        $modele->status_modele = true;
        $modele->marque_id = $request->marque_id;
        $modele->created_by = Auth::id();
        $process = $modele->save();

        //Enregistrement du systeme de log
        if ($process) saveSysActivityLog(SYS_LOG_SUCCESS, "Enregistrement du modele " . $modele->nom_modele . " avec succes dans le système.", Auth::id());
        else saveSysActivityLog(SYS_LOG_ERROR, "Echec d'enregistrement du modele " . $modele->nom_modele . " avec succes dans le système.", Auth::id());

        return response()->json([
            "status" => true,
            "reload" => false,
            "redirect_to" => null,
            "title" => "ENREGISTREMENT DU MODELE",
            "message" => "Le modele " . $modele->nom_modele . " a été ajouté avec succes"
        ]);
    }


    public function updateModeleVoiture(Request $request)
    {
        $messages = [
            "nom_modele.required" => "Le nom du modele est requis",
            "nom_modele.max" => "Le nom du modele est trop long",
        ];

        $validator = Validator::make($request->all(), [
            "nom_modele" => "bail|required|max:50",
        ], $messages);

        if ($validator->fails()) return response()->json([
            "status" => false,
            "reload" => false,
            "redirect_to" => null,
            "title" => "MISE A JOUR DU MODELE",
            "message" => $validator->errors()->first(),
        ]);

        $modele = Modele::findOrFail($request->id_modele);
        $modele->nom_modele = $request->nom_modele;
        $modele->slug_modele = Str::slug("modele-" . $request->nom_modele);
        $modele->status_modele = $request->status_modele;
        $modele->marque_id = $request->marque_id;
        $process = $modele->save();

        //Enregistrement du systeme de log
        if ($process) saveSysActivityLog(SYS_LOG_SUCCESS, "Mise à jour du modele " . $modele->nom_modele . " avec succes dans le système.", Auth::id());
        else saveSysActivityLog(SYS_LOG_ERROR, "Echec de mise à jour du modele " . $modele->nom_modele . " avec succes dans le système.", Auth::id());

        return response()->json([
            "status" => true,
            "reload" => false,
            "redirect_to" => null,
            "title" => "MISE A JOUR DU MODELE",
            "message" => "Le modele " . $modele->nom_modele . " a été mise à jour avec succes"
        ]);
    }

    public function deleteModeleVoiture(Request $request)
    {
        $modele = Modele::findOrFail($request->id_modele);
        $process = $modele->delete();

        //Enregistrement du systeme de log
        if ($process) saveSysActivityLog(SYS_LOG_SUCCESS, "Suppression du modele " . $modele->nom_modele . " dans le système", Auth::id());
        else saveSysActivityLog(SYS_LOG_SUCCESS, "Echec de suppression du modele " . $modele->nom_modele . " dans le système", Auth::id());

        return response()->json([
            "status" => $process,
            "reload" => true,
            "title" => "SUPPRESSION DU MODELE",
            "message" => "Le modele " . $modele->nom_modele . " a été bien supprimé dans le système"
        ]);
    }


}
