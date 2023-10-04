<?php

namespace App\Http\Controllers;

use App\Models\Parking;
use App\Models\Societe;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class ParkingController extends Controller
{
    public function getParkingVoiture(Request $request)
    {
        $parkings = Parking::all();
        $societes = Societe::where('status_societe', true)->orderByDesc('created_at')->get();
        return view('packages.parkings.parking', compact(['parkings', 'societes']));
    }

    public function getSpecParkingVoiture(Request $request)
    {
        $societe = Societe::where('parking_id', decodeId($request->parking_id))->get();
        return response()->json($societe);
    }

    public function infoParking(Request $request)
    {
        $parking = Parking::where('id_parking', decodeId($request->id_parking))
            ->select('parkings.*', 'users.*')
            ->join('users', 'users.id', '=', 'parkings.created_by')
            ->orderByDesc('parkings.created_at')
            ->first();
        return response()->json($parking);
    }

    public function storeParkingVoiture(Request $request)
    {
        $messages = [
            "nom_parking.required" => "Le nom du parking est requis",
            "nom_parking.max" => "Le nom du parking est trop long",
        ];

        $validator = Validator::make($request->all(), [
            "nom_parking" => "bail|required|max:100",
        ], $messages);

        if ($validator->fails()) return response()->json([
            "status" => false,
            "reload" => false,
            "redirect_to" => null,
            "title" => "ENREGISTREMENT DU PARC",
            "message" => $validator->errors()->first(),
        ]);

        $parking = new Parking();
        $parking->nom_parking = $request->nom_parking;
        $parking->slug_parking = Str::slug($request->nom_parking);
        $parking->code_parking = "PARC-" . generateToken(6, DIGIT_TOKEN);
        $parking->status_parking = true;
        $parking->created_by = Auth::id();
        $process = $parking->save();

        //Enregistrement du systeme de log
        if ($process) saveSysActivityLog(SYS_LOG_SUCCESS, "Enregistrement du parc " . $parking->nom_parking . " avec succes dans le système.", Auth::id());
        else saveSysActivityLog(SYS_LOG_ERROR, "Echec d'enregistrement du parc " . $parking->nom_parking . " avec succes dans le système.", Auth::id());

        return response()->json([
            "status" => $process,
            "reload" => false,
            "title" => "ENREGISTREMENT DU PARC",
            "message" => "Le parc " . $parking->nom_parking . " a été ajouté avec succes"
        ]);
    }

    public function updateParkingVoiture(Request $request)
    {
        $messages = [
            "nom_parking.required" => "Le nom du parking est requis",
            "nom_parking.max" => "Le nom du parking est trop long",
        ];

        $validator = Validator::make($request->all(), [
            "nom_parking" => "bail|required|max:100",
        ], $messages);

        if ($validator->fails()) return response()->json([
            "status" => false,
            "reload" => false,
            "redirect_to" => null,
            "title" => "MISE A JOUR DU PARC",
            "message" => $validator->errors()->first(),
        ]);

        $parking = Parking::findOrFail($request->id_parking);
        $parking->nom_parking = $request->nom_parking;
        $parking->slug_parking = Str::slug($request->nom_parking);
        $parking->status_parking = $request->status_parking;
        $process = $parking->save();

        //Enregistrement du systeme de log
        if ($process) saveSysActivityLog(SYS_LOG_SUCCESS, "Mise à jour du parc " . $parking->nom_parking . " avec succes dans le système.", Auth::id());
        else saveSysActivityLog(SYS_LOG_ERROR, "Echec de mise à jour du parc " . $parking->nom_parking . " avec succes dans le système.", Auth::id());

        return response()->json([
            "status" => $process,
            "reload" => true,
            "title" => "MISE A JOUR DU PARC",
            "message" => "Le parc " . $parking->nom_parking . " a été mise à jour avec succes"
        ]);
    }

    public function deleteParkingVoiture(Request $request)
    {
        $parking = Parking::findOrFail($request->id_parking);
        $process = $parking->delete();

        //Enregistrement du systeme de log
        if ($process) saveSysActivityLog(SYS_LOG_SUCCESS, "Suppression du parc " . $parking->nom_parking . " dans le système", Auth::id());
        else saveSysActivityLog(SYS_LOG_SUCCESS, "Suppression du parc " . $parking->nom_parking . " dans le système", Auth::id());

        return response()->json([
            "status" => $process,
            "reload" => true,
            "title" => "SUPPRESSION DU PARC",
            "message" => "Le parc " . $parking->nom_parking . " a été bien supprimé dans le système"
        ]);
    }
}
