<?php

namespace App\Http\Controllers\Gestionnaire;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class GestionnaireController extends Controller
{
    public function infoGestionnaire(Request $request)
    {
        $gestionnaire = User::where('id', decodeId($request->id_gestionnaire))->orderByDesc('created_at')->first();
        return response()->json($gestionnaire);
    }

    public function updateProfileGestionnaire(Request $request)
    {
        $messages = [
            "nom_user.required" => "Votre nom est requis",
            "nom_user.max" => "Votre nom est trop long",
            "prenom_user.required" => "Votre prenom est requis",
            "prenom_user.max" => "Votre prenom est trop long",
            "adresse_user.required" => "L'adresse est requise",
            "adresse_user.max" => "L'adresse est trop longue",
            "telephone_user.required" => "Le numero de telephone est requis",
            "telephone_user.min" => "Le numero de telephone est invalide",
            "email_user.required" => "Votre adresse mail est requise",
            "email_user.email" => "Votre adresse mail est invalide",
            "email_user.max" => "Votre adresse mail est trop longue",
            "telephone_user.required" => "Votre numero de telephone est requis",
        ];

        $validator = Validator::make($request->all(), [
            "nom_user" => "bail|required|max:50",
            "prenom_user" => "bail|required|max:50",
            "adresse_user" => "bail|required|max:50",
            "telephone_user" => "bail|required|min:8",
            "email_user" => "bail|required|email|max:50",
        ], $messages);

        if ($validator->fails()) return response()->json([
            "status" => false,
            "reload" => false,
            "redirect_to" => null,
            "title" => "MISE A JOUR DU COMPTE",
            "message" => $validator->errors()->first()
        ]);

        $gestionnaire = User::findOrFail(decodeId($request->id_gestionnaire));
        $gestionnaire->nom_user = $request->nom_user;
        $gestionnaire->prenom_user = $request->prenom_user;
        $gestionnaire->email_user = $request->email_user;
        $gestionnaire->telephone_user = $request->telephone_user;
        $gestionnaire->adresse_user = $request->adresse_user;
        $gestionnaire->pays_user = $request->pays_user;
        $gestionnaire->prefix_user = $request->prefix_user;

        if ($request->hasFile('avatar_user')) {
            $image = $request->avatar_user;
            $avatar_user_name = time() . '.' . $image->getClientOriginalExtension();
            $image->move('storage/uploads/', $avatar_user_name);
            $gestionnaire->avatar_user = '/storage/uploads/' . $avatar_user_name;
        }

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

    public function updateMotDePasse(Request $request)
    {
        $messages = [
            "password_old.required" => "L'ancien mot de passe est requis",
            "password_new.required" => "Le nouveau mot de passe est requis",
            "password_new.min" => "Le nouveau mot de passe est trop court",
            "confirmation_password.required" => "La confirmation du nouveau mot de passe est requis",
            "confirmation_password.same" => "Les nouveaux mots de passes ne sont pas identiques",
        ];

        $validator = Validator::make($request->all(), [
            'password_old' => ['bail', 'required'],
            'password_new' => ['bail', 'required', 'string', 'min:8'],
            'confirmation_password' => ['bail', 'required', 'same:password_new'],
        ], $messages);

        if ($validator->fails()) return response()->json([
            "status" => false,
            "reload" => false,
            "title" => "MISE A JOUR DU MOT DE PASSE",
            "message" => $validator->errors()->first()
        ]);

        $gestionnaire = User::findOrFail(decodeId($request->id_gestionnaire));

        if (Hash::check($request->password_old, $gestionnaire->password)) {
            if (!Hash::check($request->password_old, Hash::make($request->password_new))) {

                $gestionnaire->password = Hash::make($request->password_new);
                $process = $gestionnaire->save();

                //Enregistrement du systeme de log
                if ($process) saveSysActivityLog(SYS_LOG_SUCCESS, "Mise à jour du mot de passe du client " . $gestionnaire->nom_user . " " . $gestionnaire->prenom_user . " avec succes dans le système.");
                else saveSysActivityLog(SYS_LOG_ERROR, "Echec de mise à jour du mot de passe du client " . $gestionnaire->nom_user . " " . $gestionnaire->prenom_user . " avec succes dans le système.");

                return response()->json([
                    "status" => true,
                    "reload" => true,
                    "redirect_to" => Auth::logout(),
                    "title" => "MISE A JOUR DU MOT DE PASSE",
                    "message" => "Mr/Mlle " . $gestionnaire->nom_user . " " . $gestionnaire->prenom_user . " votre mot de passe a été modifié avec succes"
                ]);
            } else {
                return response()->json([
                    "status" => false,
                    "reload" => false,
                    "redirect_to" => null,
                    "title" => "MISE A JOUR DU MOT DE PASSE",
                    "message" => "Impossible d'utiliser l'ancien mot de passe comme nouveau mot de passe"
                ]);
            }
        } else {
            return response()->json([
                "status" => false,
                "reload" => false,
                "redirect_to" => null,
                "title" => "MISE A JOUR DU MOT DE PASSE",
                "message" => "Votre ancien mot de passe est incorrect"
            ]);
        }
    }
}
