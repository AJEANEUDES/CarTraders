<?php

namespace App\Http\Controllers;

use App\Models\Facture;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Response;

class FactureController extends Controller
{
    public function getFacture()
    {
        $factures = Facture::select('factures.*', 'reservations.*', 'users.*', 'voitures.*', 'marques.*', 'modeles.*')
            ->join('reservations', 'reservations.id_reservation', '=', 'factures.reservation_id')
            ->join('users', 'users.id', '=', 'factures.client_id')
            ->join('voitures', 'voitures.id_voiture', '=', 'reservations.voiture_id')
            ->join('marques', 'marques.id_marque', '=', 'voitures.marque_id')
            ->join('modeles', 'modeles.id_modele', '=', 'voitures.modele_id')
            //->join('users', 'users.id', '=', 'factures.created_by')
            ->orderByDesc('factures.created_at')
            ->get();
        return view('packages.factures.facture', compact('factures'));
    }

    public function getSpecFacture()
    {
    }

    public function listeFacture()
    {   
        $client = Auth::user();
        $mes_factures = Facture::where('factures.client_id', $client->id)
            ->select('factures.*', 'voitures.*', 'reservations.*', 'marques.*', 'modeles.*')
            ->join('reservations', 'reservations.id_reservation', '=', 'factures.reservation_id')
            ->join('voitures', 'voitures.id_voiture', '=', 'reservations.voiture_id')
            ->join('marques', 'marques.id_marque', '=', 'voitures.marque_id')
            ->join('modeles', 'modeles.id_modele', '=', 'voitures.modele_id')
            ->orderByDesc('factures.created_at')
            ->get();
        return view('pages.utilisateur.facture', compact([
            'mes_factures', 'client'
        ]));
    }

    public function infoFacture(Request $request)
    {
        $facture = Facture::where('id_facture', decodeId($request->id_facture))
            ->select('factures.*', 'reservations.*', 'users.*', 'voitures.*', 'marques.*', 'modeles.*', 'societes.*', 'parkings.*')
            ->join('reservations', 'reservations.id_reservation', '=', 'factures.reservation_id')
            ->join('users', 'users.id', '=', 'factures.client_id')
            ->join('voitures', 'voitures.id_voiture', '=', 'reservations.voiture_id')
            ->join('marques', 'marques.id_marque', '=', 'voitures.marque_id')
            ->join('modeles', 'modeles.id_modele', '=', 'voitures.modele_id')
            ->join('societes', 'societes.id_societe', '=', 'reservations.societe_id')
            ->join('parkings', 'parkings.id_parking', '=', 'societes.parking_id')
            ->orderByDesc('factures.created_at')
            ->first();
        return response()->json($facture);
    }

    public function storeFacture(Request $request)
    {
        $messages = [
            "path_facture.required" => "Veuillez selectionnez un fichier.",
            "path_facture.mimes" => "Le fichier que vous avez selectionnez est invalide",
            "path_facture.max" => "Le fichier que vous avez selectionnez est trop lourde",
        ];

        $validator = Validator::make($request->all(), [
            "path_facture" => "bail|max:2048",
            "path_facture.*" => "bail|required|file|mimes:jpg,jpeg,png",
        ], $messages);

        if ($validator->fails()) return response()->json([
            "status" => false,
            "reload" => false,
            "title" => "ENVOIE DE LA FACTURE",
            "message" => $validator->errors()->first(),
        ]);

        $facture = new Facture();
        $facture->path_facture = $request->path_facture;
        $facture->reservation_id = $request->reservation;
        $facture->client_id = $request->client;
        $facture->created_by = Auth::id();

        if ($request->hasFile('path_facture')) {
            $facture_client = $request->path_facture;
            $facture_new_name = time() . '.' . $facture_client->getClientOriginalExtension();
            $facture_client->move('storage/factures/', $facture_new_name);
            $facture->path_facture = '/storage/factures/' . $facture_new_name;
        }

        $process = $facture->save();

        //Enregistrement du systeme de log
        if ($process) saveSysActivityLog(SYS_LOG_SUCCESS, "Enregistrement de la facture avec succes dans le système.", Auth::id());
        else saveSysActivityLog(SYS_LOG_ERROR, "Echec d'enregistrement de la facture avec succes dans le système.", Auth::id());

        return response()->json([
            "status" => true,
            "reload" => false,
            "redirect_to" => null,
            "title" => "ENVOIE DE LA FACTURE",
            "message" => "La facture a été envoyée avec succes"
        ]);
    }

    public function updateFacture(Request $request)
    {
        $messages = [
            "path_facture.required" => "Veuillez selectionnez un fichier.",
            "path_facture.mimes" => "Le fichier que vous avez selectionnez est invalide",
            "path_facture.max" => "Le fichier que vous avez selectionnez est trop lourde",
        ];

        $validator = Validator::make($request->all(), [
            "path_facture" => "bail|max:2048",
            "path_facture.*" => "bail|required|file|mimes:jpg,jpeg,png",
        ], $messages);

        if ($validator->fails()) return response()->json([
            "status" => false,
            "reload" => false,
            "title" => "MISE A JOUR DE LA FACTURE",
            "message" => $validator->errors()->first(),
        ]);

        $facture = Facture::findOrFail($request->id_facture);
        $facture->path_facture = $request->path_facture;

        if ($request->hasFile('path_facture')) {
            $facture_client = $request->path_facture;
            $facture_new_name = time() . '.' . $facture_client->getClientOriginalExtension();
            $facture_client->move('storage/factures/', $facture_new_name);
            $facture->path_facture = '/storage/factures/' . $facture_new_name;
        }

        $process = $facture->save();

        //Enregistrement du systeme de log
        if ($process) saveSysActivityLog(SYS_LOG_SUCCESS, "Mise à jour de la facture avec succes dans le système.", Auth::id());
        else saveSysActivityLog(SYS_LOG_ERROR, "Echec de mise à jour de la facture avec succes dans le système.", Auth::id());

        return response()->json([
            "status" => true,
            "reload" => false,
            "redirect_to" => null,
            "title" => "MISE A JOUR DE LA FACTURE",
            "message" => "La facture a été mise à jour avec succes"
        ]);
    }

    // public function downloadFacture(Request $request)
    // {
    //     $facture = Facture::where('id_facture', decodeId($request->id_facture))->first();
    //     //return response()->json($facture->path_facture);
    //     $file = public_path() . $facture->path_facture;
    //     // $headers = array(
    //     //     'Content-Type: application/pdf',
    //     //     'Content-Type: application/image',
    //     // );
    //     return Response::download($file);
    // }

    public function deleteFacture()
    {
    }
}
