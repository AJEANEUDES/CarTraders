<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    public function tableauDeBord()
    {
        $client = Auth::user();
        return view('pages.utilisateur.dashbord', compact('client'));
    }

    public function profile()
    {
        $client = Auth::user();
        return view('pages.utilisateur.compte', compact('client'));
    }

    public function updateUtilisateur(Request $request)
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
            "password.min" => "Le mot de passe est trop court",
            "password.same" => "Les mots de passes ne sont pas identiques",
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

        $client = User::findOrFail(decodeId($request->id_client));
        $client->nom_user = $request->nom_user;
        $client->prenom_user = $request->prenom_user;
        $client->email_user = $request->email_user;
        $client->telephone_user = $request->telephone_user;
        $client->adresse_user = $request->adresse_user;
        $client->pays_user = $request->pays_user;
        $client->prefix_user = $request->prefix_user;

        if ($request->hasFile('avatar_user')) {
            $image = $request->avatar_user;
            $avatar_user_name = time() . '.' . $image->getClientOriginalExtension();
            $image->move('storage/uploads/', $avatar_user_name);
            $client->avatar_user = '/storage/uploads/' . $avatar_user_name;
        }

        $process = $client->save();

        //Enregistrement du systeme de log
        if ($process) saveSysActivityLog(SYS_LOG_SUCCESS, "Mise à jour du client " . $client->nom_user . " " . $client->prenom_user . " avec succes dans le système.", $client->id);
        else saveSysActivityLog(SYS_LOG_ERROR, "Echec de mise à jour du client " . $client->nom_user . " " . $client->prenom_user . " avec succes dans le système.", $client->id);

        return response()->json([
            "status" => true,
            "reload" => false,
            "redirect_to" => route('utilisateur.profile'),
            "title" => "MISE A JOUR DU COMPTE",
            "message" => "Mr/Mlle " . $client->nom_user . " " . $client->prenom_user . " votre compte a été modifié avec succes"
        ]);
    }

    public function motDePasse()
    {
        $client = Auth::user();
        return view('pages.utilisateur.password', compact('client'));
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

        $client = User::findOrFail(decodeId($request->id_client));

        if (Hash::check($request->password_old, $client->password)) {
            if (!Hash::check($request->password_old, Hash::make($request->password_new))) {

                $client->password = Hash::make($request->password_new);
                $process = $client->save();

                //Enregistrement du systeme de log
                if ($process) saveSysActivityLog(SYS_LOG_SUCCESS, "Mise à jour du mot de passe du client " . $client->nom_user . " " . $client->prenom_user . " avec succes dans le système.", $client->id);
                else saveSysActivityLog(SYS_LOG_ERROR, "Echec de mise à jour du mot de passe du client " . $client->nom_user . " " . $client->prenom_user . " avec succes dans le système.", $client->id);

                return response()->json([
                    "status" => true,
                    "reload" => false,
                    "redirect_to" => route('utilisateur.update.mdp'),
                    "title" => "MISE A JOUR DU MOT DE PASSE",
                    "message" => "Mr/Mlle " . $client->nom_user . " " . $client->prenom_user . " votre mot de passe a été modifié avec succes"
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

    public function infoClient(Request $request)
    {
        $client = User::where('id', decodeId($request->id_client))->first();
        return response()->json($client);
    }
}
