<?php

namespace App\Http\Controllers;

use App\Models\Parking;
use App\Models\Societe;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class SocieteController extends Controller
{
    public function getSociete()
    {
        $societes = Societe::all();
        $parkings = Parking::where('status_parking', true)->orderByDesc('created_at')->get();
        return view('packages.societes.societe', compact('societes', 'parkings'));
    }

    public function infoSociete(Request $request)
    {
        $societe = Societe::where('id_societe', decodeId($request->id_societe))
            ->select('societes.*', 'parkings.*', 'users.*')
            ->join('parkings', 'parkings.id_parking', '=', 'societes.parking_id')
            ->join('users', 'users.id', '=', 'societes.created_by')
            ->orderByDesc('societes.created_at')
            ->first();
        return response()->json($societe);
    }

    public function storeSociete(Request $request)
    {
        $messages = [
            "nom_societe.required" => "Le nom de la societe est requis",
            "nom_societe.max" => "Le nom de la societe est trop long",
            "nom_societe.unique" => "Cette societe existe deja dans le systeme",
            "adresse_societe.required" => "L'adresse de la societe est requis",
            "adresse_societe.max" => "L'adresse de la societe est trop long",
            "telephone_societe1.required" => "Le numero de telephone1 de la societe est requis",
            "telephone_societe1.max" => "Le numero de telephone1 de la societe est trop long",
            "telephone_societe2.max" => "Le numero de telephone2 de la societe est trop long",
            "parking_id.required" => "Le parc de la societe est requis",
        ];

        $validator = Validator::make($request->all(), [
            "nom_societe" => "bail|required|max:100|unique:societes,nom_societe",
            "adresse_societe" => "bail|required|max:100",
            "telephone_societe1" => "bail|required|max:100",
            "telephone_societe2" => "bail|max:100",
            "parking_id" => "bail|required",
        ], $messages);

        if ($validator->fails()) return response()->json([
            "status" => false,
            "reload" => false,
            "redirect_to" => null,
            "title" => "ENREGISTREMENT DE LA SOCIETE",
            "message" => $validator->errors()->first(),
        ]);

        $societe = new Societe();
        $societe->nom_societe = $request->nom_societe;
        $societe->code_societe = "SOCIETE-" . generateToken(6, DIGIT_TOKEN);
        $societe->slug_societe = Str::slug("societe-" . $request->nom_societe);
        $societe->adresse_societe = $request->adresse_societe;
        $societe->telephone_societe1 = $request->telephone_societe1;
        $societe->telephone_societe2 = $request->telephone_societe2;
        $societe->status_societe = true;
        $societe->parking_id = $request->parking_id;
        $societe->created_by = Auth::id();
        $process = $societe->save();

        //Enregistrement du systeme de log
        if ($process) saveSysActivityLog(SYS_LOG_SUCCESS, "Enregistrement de la sociète " . $societe->nom_societe . " avec succes dans le système.", Auth::id());
        else saveSysActivityLog(SYS_LOG_ERROR, "Echec d'enregistrement de la sociète " . $societe->nom_societe . " avec succes dans le système.", Auth::id());

        return response()->json([
            "status" => true,
            "reload" => false,
            "redirect_to" => null,
            "title" => "ENREGISTREMENT DE LA SOCIETE",
            "message" => "La sociète " . $societe->nom_societe . " a été ajoutée avec succes"
        ]);
    }

    public function updateSociete(Request $request)
    {
        $messages = [
            "nom_societe.required" => "Le nom de la sociète est requis",
            "nom_societe.max" => "Le nom de la sociète est trop long",
            "adresse_societe.required" => "L'adresse de la sociète est requis",
            "adresse_societe.max" => "L'adresse de la sociète est trop long",
            "telephone_societe1.required" => "Le numero de telephone1 de la sociète est requis",
            "telephone_societe1.max" => "Le numero de telephone1 de la sociète est trop long",
            "telephone_societe2.max" => "Le numero de telephone2 de la sociète est trop long",
        ];

        $validator = Validator::make($request->all(), [
            "nom_societe" => "bail|required|max:100",
            "adresse_societe" => "bail|required|max:100",
            "telephone_societe1" => "bail|required|max:100",
            "telephone_societe2" => "bail|max:100",
        ], $messages);

        if ($validator->fails()) return response()->json([
            "status" => false,
            "reload" => false,
            "redirect_to" => null,
            "title" => "MISE A JOUR DE LA SOCIETE",
            "message" => $validator->errors()->first(),
        ]);

        $societe = Societe::findOrFail($request->id_societe);
        $societe->nom_societe = $request->nom_societe;
        $societe->slug_societe = Str::slug("societe-" . $request->nom_societe);
        $societe->adresse_societe = $request->adresse_societe;
        $societe->telephone_societe1 = $request->telephone_societe1;
        $societe->telephone_societe2 = $request->telephone_societe2;
        $societe->status_societe = $request->status_societe;
        $process = $societe->save();

        //Enregistrement du systeme de log
        if ($process) saveSysActivityLog(SYS_LOG_SUCCESS, "Mise à jour de la sociète " . $societe->nom_societe . " avec succes dans le système.", Auth::id());
        else saveSysActivityLog(SYS_LOG_ERROR, "Echec de mise à jour de la sociète " . $societe->nom_societe . " avec succes dans le système.", Auth::id());

        return response()->json([
            "status" => true,
            "reload" => false,
            "redirect_to" => null,
            "title" => "MISE A JOUR DE LA SOCIETE",
            "message" => "La sociète " . $societe->nom_societe . " a été mise à jour avec succes"
        ]);
    }

    public function deleteSociete(Request $request)
    {
        $societe = Societe::findOrFail($request->id_societe);
        $process = $societe->delete();

        //Enregistrement du systeme de log
        if ($process) saveSysActivityLog(SYS_LOG_SUCCESS, "Suppression de la sociète " . $societe->nom_societe . " dans le système", Auth::id());
        else saveSysActivityLog(SYS_LOG_SUCCESS, "Echec de suppression de la sociète " . $societe->nom_societe . " dans le système", Auth::id());

        return response()->json([
            "status" => $process,
            "reload" => true,
            "title" => "SUPPRESSION DE LA SOCIETE",
            "message" => "La sociète " . $societe->nom_societe . " a été bien supprimée dans le système"
        ]);
    }
}
