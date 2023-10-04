<?php

namespace App\Http\Controllers;

use App\Models\Service;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class ServiceController extends Controller
{
    public function getServiceVoiture()
    {
        $services = Service::select('services.*', 'users.*')
            ->join('users', 'users.id', '=', 'services.created_by')
            ->orderByDesc('services.created_at')
            ->get();
        return view('packages.services.service', compact('services'));
    }

    public function infoService(Request $request)
    {
        $service = Service::where('id_service', decodeId($request->id_service))
            ->select('services.*', 'users.*')
            ->join('users', 'users.id', '=', 'services.created_by')
            ->orderByDesc('services.created_at')
            ->first();
        return response()->json($service);
    }

    public function storeServiceVoiture(Request $request)
    {
        $messages = [
            "nom_service.required" => "Le nom du service est requis",
            "nom_service.max" => "Le nom du service est trop long",
            "nom_service.unique" => "Ce service existe deja dans le système",
        ];

        $validator = Validator::make($request->all(), [
            "nom_service" => "bail|required|max:50|unique:services,nom_service",
        ], $messages);

        if ($validator->fails()) return response()->json([
            "status" => false,
            "reload" => false,
            "redirect_to" => null,
            "title" => "ENREGISTREMENT DU SERVICE",
            "message" => $validator->errors()->first(),
        ]);

        $service = new Service();
        $service->nom_service = $request->nom_service;
        $service->code_service = "SERVICE-" . generateToken(6, DIGIT_TOKEN);
        $service->slug_service = Str::slug("service-" . $request->nom_service);
        $service->status_service = true;
        $service->created_by = Auth::id();
        $process = $service->save();

        //Enregistrement du systeme de log
        if ($process) saveSysActivityLog(SYS_LOG_SUCCESS, "Enregistrement du service " . $service->nom_service . " avec succes dans le système.", Auth::id());
        else saveSysActivityLog(SYS_LOG_ERROR, "Echec d'enregistrement du service " . $service->nom_service . " avec succes dans le système.", Auth::id());

        return response()->json([
            "status" => true,
            "reload" => false,
            "redirect_to" => null,
            "title" => "ENREGISTREMENT DU SERVICE",
            "message" => "Le service " . $service->nom_service . " a été ajouté avec succes"
        ]);
    }

    public function updateServiceVoiture(Request $request)
    {
        $messages = [
            "nom_service.required" => "Le nom du service est requis",
            "nom_service.max" => "Le nom du service est trop long",
        ];

        $validator = Validator::make($request->all(), [
            "nom_service" => "bail|required|max:50",
        ], $messages);

        if ($validator->fails()) return response()->json([
            "status" => false,
            "reload" => false,
            "redirect_to" => null,
            "title" => "MISE A JOUR DU SERVICE",
            "message" => $validator->errors()->first(),
        ]);

        $service = Service::findOrFail($request->id_service);
        $service->nom_service = $request->nom_service;
        $service->slug_service = Str::slug("service-" . $request->nom_service);
        $service->status_service = $request->status_service;
        $process = $service->save();

        //Enregistrement du systeme de log
        if ($process) saveSysActivityLog(SYS_LOG_SUCCESS, "Mise à jour du service " . $service->nom_service . " avec succes dans le système.", Auth::id());
        else saveSysActivityLog(SYS_LOG_ERROR, "Echec de mise à jour du service " . $service->nom_service . " avec succes dans le système.", Auth::id());

        return response()->json([
            "status" => true,
            "reload" => false,
            "redirect_to" => null,
            "title" => "MISE A JOUR DU SERVICE",
            "message" => "Le service " . $service->nom_service . " a été mise à jour avec succes"
        ]);
    }

    public function deleteServiceVoiture(Request $request)
    {
        $service = Service::findOrFail($request->id_service);
        $process = $service->delete();

        //Enregistrement du systeme de log
        if ($process) saveSysActivityLog(SYS_LOG_SUCCESS, "Suppression du service " . $service->nom_service . " dans le système", Auth::id());
        else saveSysActivityLog(SYS_LOG_SUCCESS, "Echec de suppression du service " . $service->nom_service . " dans le système", Auth::id());

        return response()->json([
            "status" => $process,
            "reload" => true,
            "title" => "SUPPRESSION DU SERVICE",
            "message" => "Le service " . $service->nom_service . " a été bien supprimé dans le système"
        ]);
    }
}
