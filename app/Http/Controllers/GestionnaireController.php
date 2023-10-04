<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Image;
use App\Models\Marque;
use App\Models\Modele;
use App\Models\Societe;
use App\Models\Voiture;
use Illuminate\Http\Request;
use App\Models\GestionnaireSociete;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class GestionnaireController extends Controller
{
    public function tableauDeBord()
    {
        $marques = Marque::count();
        $modeles = Modele::count();
        $gestionnaire_id = Auth::id();
        $societe = GestionnaireSociete::where('gestionnaire_id', $gestionnaire_id)->first();
        $voitures = Voiture::where('societe_id', $societe->societe_id)->count();
        $images = Image::where('societe_id', $societe->societe_id)->count();
        return view('pages.gestionnaire.dashbord', compact([
            'marques', 'modeles', 'voitures', 'images'
        ]));
    }

    public function profileGestionnaire()
    {
        return view('packages.profiles.gestionnaire.profile');
    }

    public function getGestionnaire()
    {
        $gestionnaires = User::where('roles_user', 'G02')->orderByDesc('created_at')->get();
        $societes = Societe::where('status_societe', true)->orderByDesc('created_at')->get();
        return view('packages.gestionnaires.gestionnaire', compact(['gestionnaires', 'societes']));
    }

    public function infoGestionnaire(Request $request)
    {
        $gestionnaire_societe = GestionnaireSociete::where('gestionnaire_id', decodeId($request->id_gestionnaire))->first();
        $societe = Societe::where('id_societe', $gestionnaire_societe->societe_id)->first();

        $gestionnaire = User::where('id', decodeId($request->id_gestionnaire))
            ->orderByDesc('created_at')->first();
        return response()->json([
            'gestionnaire' => $gestionnaire,
            'societe' => $societe
        ]);
    }

    public function storeGestionnaire(Request $request)
    {
        $messages = [
            "nom_user.required" => "Le nom est requis",
            "prenom_user.required" => "Le prenom est requis",
            "email_user.required" => "L'email est requis",
            "email_user.unique" => "Cet email existe deja",
            "password.required" => "Le mot de passe est requis",
            "password.min" => "Le mot de passe est trop court",
            "telephone_user.required" => "Le numero de telephone est requis",
            "telephone_user.unique" => "Ce numero de telephone existe deja",
            "adresse_user.required" => "L'adresse est requise",
        ];

        $validator = Validator::make($request->all(), [
            "nom_user" => "bail|required",
            "prenom_user" => "bail|required",
            "email_user" => "bail|required|unique:users,email_user",
            "password" => "bail|required|min:8",
            "telephone_user" => "bail|required|unique:users,telephone_user",
            "adresse_user" => "bail|required",
        ], $messages);

        if ($validator->fails()) return response()->json([
            "status" => false,
            "reload" => false,
            "redirect_to" => null,
            "title" => "ENREGISTREMENT DE L'ADMIN",
            "message" => $validator->errors()->first(),
        ]);

        $gestionnaire = new User();
        $gestionnaire->nom_user = $request->nom_user;
        $gestionnaire->prenom_user = $request->prenom_user;
        $gestionnaire->email_user = $request->email_user;
        $gestionnaire->adresse_user = $request->adresse_user;
        $gestionnaire->telephone_user = $request->telephone_user;
        $gestionnaire->roles_user = "G02";
        $gestionnaire->password = Hash::make($request->password);
        $gestionnaire->code_user = "GES-" . generateToken(6, DIGIT_TOKEN);
        $gestionnaire->status_user = true;

        $process = $gestionnaire->save();

        $gestionnaireSociete = new GestionnaireSociete();
        $gestionnaireSociete->gestionnaire_id = $gestionnaire->id;
        $gestionnaireSociete->societe_id = $request->societe_id;
        $gestionnaireSociete->save();

        //Enregistrement du systeme de log
        if ($process) saveSysActivityLog(SYS_LOG_SUCCESS, "Enregistrement du gestionnaire " . $gestionnaire->nom_user . " " . $gestionnaire->prenom_user . " avec succes dans le système.", Auth::id());
        else saveSysActivityLog(SYS_LOG_ERROR, "Echec d'enregistrement du gestionnaire " . $gestionnaire->nom_user . " " . $gestionnaire->prenom_user . " avec succes dans le système.", Auth::id());

        return response()->json([
            "status" => true,
            "reload" => false,
            "redirect_to" => null,
            "title" => "ENREGISTREMENT DU GESTIONNAIRE",
            "message" => "Le gestionnaire " . $gestionnaire->nom_user . " " . $gestionnaire->prenom_user . " a été ajouté avec succes"
        ]);
    }

    public function updateGestionnaire(Request $request)
    {
        $gestionnaire = User::findOrFail($request->id_gestionnaire);
        $gestionnaire->status_user = $request->status_user;
        $process = $gestionnaire->save();

        //Enregistrement du systeme de log
        if ($process) saveSysActivityLog(SYS_LOG_SUCCESS, "Mise à jour du gestionnaire " . $gestionnaire->nom_user . " " . $gestionnaire->prenom_user . " avec succes dans le système.", Auth::id());
        else saveSysActivityLog(SYS_LOG_ERROR, "Echec de mise à jour du gestionnaire " . $gestionnaire->nom_user . " " . $gestionnaire->prenom_user . " avec succes dans le système.", Auth::id());

        return response()->json([
            "status" => true,
            "reload" => false,
            "title" => "MISE A JOUR DU COMPTE",
            "message" => "Mr/Mlle " . $gestionnaire->nom_user . " " . $gestionnaire->prenom_user . " votre compte a été modifié avec succes"
        ]);
    }

    public function deleteGestionnaire(Request $request)
    {
        $gestionnaire = User::findOrFail($request->id_gestionnaire);
        $process = $gestionnaire->delete();

        //Enregistrement du systeme de log
        if ($process) saveSysActivityLog(SYS_LOG_SUCCESS, "Suppression du gestionnaire " . $gestionnaire->nom_user . " " . $gestionnaire->prenom_user . " dans le système", Auth::id());
        else saveSysActivityLog(SYS_LOG_SUCCESS, "Echec de suppression du gestionnaire " . $gestionnaire->nom_user . " " . $gestionnaire->prenom_user . " dans le système", Auth::id());

        return response()->json([
            "status" => $process,
            "reload" => true,
            "title" => "SUPPRESSION DU GESTIONNAIRE",
            "message" => "Le gestionnaire " . $gestionnaire->nom_user . " " . $gestionnaire->prenom_user . " a été bien supprimé dans le système"
        ]);
    }



}
