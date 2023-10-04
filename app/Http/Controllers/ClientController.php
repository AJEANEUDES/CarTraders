<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ClientController extends Controller
{
    public function getClients()
    {
        $clients = User::where('roles_user', 'C01')->orderByDesc('created_at')->get();
        return view('packages.clients.client', compact('clients'));
    }

    public function infoClient(Request $request)
    {
        $client = User::where('id', decodeId($request->id_client))->orderByDesc('created_at')->first();
        return response()->json($client);
    }

    public function updateClient(Request $request)
    {
        $client = User::findOrFail($request->id_client);
        $client->status_user = $request->status_user;
        $process = $client->save();

        //Enregistrement du systeme de log
        if ($process) saveSysActivityLog(SYS_LOG_SUCCESS, "Mise à jour du client " . $client->nom_user . " " . $client->prenom_user . " avec succes dans le système.", Auth::id());
        else saveSysActivityLog(SYS_LOG_ERROR, "Echec de mise à jour du client " . $client->nom_user . " " . $client->prenom_user . " avec succes dans le système.", Auth::id());

        return response()->json([
            "status" => true,
            "reload" => false,
            "title" => "MISE A JOUR DU COMPTE",
            "message" => "Mr/Mlle " . $client->nom_user . " " . $client->prenom_user . " votre compte a été modifié avec succes"
        ]);
    }

    public function deleteClient(Request $request)
    {
        $client = User::findOrFail($request->id_client);
        $process = $client->delete();

        //Enregistrement du systeme de log
        if ($process) saveSysActivityLog(SYS_LOG_SUCCESS, "Suppression du client " . $client->nom_user . " " . $client->prenom_user . " dans le système", Auth::id());
        else saveSysActivityLog(SYS_LOG_SUCCESS, "Echec de suppression du client " . $client->nom_user . " " . $client->prenom_user . " dans le système", Auth::id());

        return response()->json([
            "status" => $process,
            "reload" => true,
            "title" => "SUPPRESSION DU CLIENT",
            "message" => "Le client " . $client->nom_user . " " . $client->prenom_user . " a été bien supprimé dans le système"
        ]);
    }
}
