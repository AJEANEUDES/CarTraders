<?php

namespace App\Http\Controllers;

use App\Models\Facture;
use App\Models\User;
use App\Models\Marque;
use App\Models\Modele;
use App\Models\Parking;
use App\Models\Reservation;
use App\Models\Service;
use App\Models\Societe;
use App\Models\Voiture;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AdminController extends Controller
{
    public function tableauDeBord()
    {
        $marques = Marque::count();
        $modeles = Modele::count();
        $voitures = Voiture::count();
        $images = Voiture::count();
        $societes = Societe::count();
        $parcs = Parking::count();
        $services = Service::count();
        $clients = User::where('roles_user', 'C01')->count();
        $gestionnaires = User::where('roles_user', 'G02')->count();
        $admins = User::where('roles_user', 'A03')->count();
        $reservations = Reservation::where('status_annulation', false)
            ->where('status_reservation', true)
            ->count();
        
        $factures = Facture::count();

        return view('pages.admin.dashbord', compact([
            'marques', 'modeles', 'voitures', 'images',
            'societes', 'parcs', 'services', 'clients',
            'gestionnaires', 'admins', 'reservations',
            'factures'
        ]));
    }

    public function profileAdmin()
    {
        return view('packages.profiles.admin.profile');
    }

    public function getAdmin()
    {
        $admins = User::where('roles_user', 'A03')->orderByDesc('created_at')->get();
        return view('packages.admins.admin', compact('admins'));
    }

    public function infoAdmin(Request $request)
    {
        $admin = User::where('id', decodeId($request->id_admin))->orderByDesc('created_at')->first();
        return response()->json($admin);
    }

    public function storeAdmin(Request $request)
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

        $admin = new User();
        $admin->nom_user = $request->nom_user;
        $admin->prenom_user = $request->prenom_user;
        $admin->email_user = $request->email_user;
        $admin->adresse_user = $request->adresse_user;
        $admin->telephone_user = $request->telephone_user;
        $admin->roles_user = "A03";
        $admin->password = Hash::make($request->password);
        $admin->code_user = "ADM-" . generateToken(6, DIGIT_TOKEN);
        $admin->status_user = true;
        $process = $admin->save();

        //Enregistrement du systeme de log
        if ($process) saveSysActivityLog(SYS_LOG_SUCCESS, "Enregistrement de l'administrateur " . $admin->nom_user . " " . $admin->prenom_user . " avec succes dans le système.", Auth::id());
        else saveSysActivityLog(SYS_LOG_ERROR, "Echec d'enregistrement de l'administrateur " . $admin->nom_user . " " . $admin->prenom_user . " avec succes dans le système.", Auth::id());

        return response()->json([
            "status" => true,
            "reload" => false,
            "redirect_to" => null,
            "title" => "ENREGISTREMENT DE L'ADMIN",
            "message" => "L'admin " . $admin->nom_user . " " . $admin->prenom_user . " a été ajouté avec succes"
        ]);
    }

    public function updateAdmin(Request $request)
    {
        $admin = User::findOrFail($request->id_admin);
        $admin->status_user = $request->status_user;
        $process = $admin->save();

        //Enregistrement du systeme de log
        if ($process) saveSysActivityLog(SYS_LOG_SUCCESS, "Mise à jour de l'admin " . $admin->nom_user . " " . $admin->prenom_user . " avec succes dans le système.", Auth::id());
        else saveSysActivityLog(SYS_LOG_ERROR, "Echec de mise à jour de l'admin " . $admin->nom_user . " " . $admin->prenom_user . " avec succes dans le système.", Auth::id());

        return response()->json([
            "status" => true,
            "reload" => false,
            "title" => "MISE A JOUR DU COMPTE",
            "message" => "Mr/Mlle " . $admin->nom_user . " " . $admin->prenom_user . " votre compte a été modifié avec succes"
        ]);
    }

    public function updateProfileAdmin(Request $request)
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

        $admin = User::findOrFail(decodeId($request->id_admin));
        $admin->nom_user = $request->nom_user;
        $admin->prenom_user = $request->prenom_user;
        $admin->email_user = $request->email_user;
        $admin->telephone_user = $request->telephone_user;
        $admin->adresse_user = $request->adresse_user;
        $admin->pays_user = $request->pays_user;
        $admin->prefix_user = $request->prefix_user;

        if ($request->hasFile('avatar_user')) {
            $image = $request->avatar_user;
            $avatar_user_name = time() . '.' . $image->getClientOriginalExtension();
            $image->move('storage/uploads/', $avatar_user_name);
            $admin->avatar_user = '/storage/uploads/' . $avatar_user_name;
        }

        $process = $admin->save();

        //Enregistrement du systeme de log
        if ($process) saveSysActivityLog(SYS_LOG_SUCCESS, "Mise à jour de l'admin " . $admin->nom_user . " " . $admin->prenom_user . " avec succes dans le système.", Auth::id());
        else saveSysActivityLog(SYS_LOG_ERROR, "Echec de mise à jour de l'admin " . $admin->nom_user . " " . $admin->prenom_user . " avec succes dans le système.", Auth::id());

        return response()->json([
            "status" => true,
            "reload" => false,
            "title" => "MISE A JOUR DU COMPTE",
            "message" => "Mr/Mlle " . $admin->nom_user . " " . $admin->prenom_user . " votre compte a été modifié avec succes"
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

        $admin = User::findOrFail(decodeId($request->id_admin));

        if (Hash::check($request->password_old, $admin->password)) {
            if (!Hash::check($request->password_old, Hash::make($request->password_new))) {

                $admin->password = Hash::make($request->password_new);
                $process = $admin->save();

                //Enregistrement du systeme de log
                if ($process) saveSysActivityLog(SYS_LOG_SUCCESS, "Mise à jour du mot de passe du client " . $admin->nom_user . " " . $admin->prenom_user . " avec succes dans le système.");
                else saveSysActivityLog(SYS_LOG_ERROR, "Echec de mise à jour du mot de passe du client " . $admin->nom_user . " " . $admin->prenom_user . " avec succes dans le système.");

                return response()->json([
                    "status" => true,
                    "reload" => true,
                    "redirect_to" => Auth::logout(),
                    "title" => "MISE A JOUR DU MOT DE PASSE",
                    "message" => "Mr/Mlle " . $admin->nom_user . " " . $admin->prenom_user . " votre mot de passe a été modifié avec succes"
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

    public function deleteAdmin(Request $request)
    {
        $admin = User::findOrFail($request->id_admin);
        $process = $admin->delete();

        //Enregistrement du systeme de log
        if ($process) saveSysActivityLog(SYS_LOG_SUCCESS, "Suppression de l'administrateur " . $admin->nom_user . " " . $admin->prenom_user . " dans le système", Auth::id());
        else saveSysActivityLog(SYS_LOG_SUCCESS, "Echec de suppression de l'administrateur " . $admin->nom_user . " " . $admin->prenom_user . " dans le système", Auth::id());

        return response()->json([
            "status" => $process,
            "reload" => true,
            "title" => "SUPPRESSION DE L'ADMIN",
            "message" => "L'admin " . $admin->nom_user . " " . $admin->prenom_user . " a été bien supprimé dans le système"
        ]);
    }


    
}
