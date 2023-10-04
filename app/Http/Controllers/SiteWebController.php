<?php

namespace App\Http\Controllers;

use App\Mail\ContactezNous;
use App\Models\User;
use App\Models\Image;
use App\Models\Marque;
use App\Models\Modele;
use App\Models\Service;
use App\Models\Voiture;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class SiteWebController extends Controller
{
    public function accueil()
    {
        $voitures = Voiture::where('status_voiture', true)
            ->select('voitures.*', 'marques.*', 'modeles.*')
            ->join('marques', 'marques.id_marque', '=', 'voitures.marque_id')
            ->join('modeles', 'modeles.id_modele', '=', 'voitures.modele_id')
            ->orderByDesc('voitures.created_at')
            ->limit(15)
            ->get();
        return view('pages.accueil', compact('voitures'));
    }

    public function acheterVoiture()
    {
        $voitures = Voiture::getAllVoitures('');
        $marques = Marque::where('status_marque', true)->orderByDesc('created_at')->get();
        $modeles = Modele::where('status_modele', true)->orderByDesc('created_at')->get();
        //$marques = Marque::where('status_marque', true)->orderByDesc('created_at')->limit(5)->get();
        return view('pages.acheterVoiture', compact([
            'voitures', 'marques', 'modeles'
        ]));
    }


    
    public function fetchDataVoiture(Request $request)
    {
        $prix_min = $request->prix_min;
        $prix_max = $request->prix_max;

        $kilo_min = $request->kilo_min;
        $kilo_max = $request->kilo_max;

        $annee_min = $request->annee_min;
        $annee_max = $request->annee_max;

        $carburant_diesel = $request->carburant_diesel;
        $carburant_essence = $request->carburant_essence;
        $carburant_hybride = $request->carburant_hybride;
        $carburant_electrique = $request->carburant_electrique;
        $carburant_glp = $request->carburant_glp;
        $carburant_gnv = $request->carburant_gnv;
        $boite_manuelle = $request->boite_manuelle;
        $boite_automatique = $request->boite_automatique;
        $boite_robotisee = $request->boite_robotisee;

        $marques = $request->marques;
        $modeles = $request->modeles;
        $query = $request->search_voiture;

        if ($request->ajax()) {
            $voitures = Voiture::getAllVoitures(
                $query,
                $prix_min,
                $prix_max,
                $marques,
                $modeles,
                $kilo_min,
                $kilo_max,
                $annee_min,
                $annee_max,
                $carburant_diesel,
                $carburant_essence,
                $carburant_hybride,
                $carburant_electrique,
                $carburant_glp,
                $carburant_gnv,
                $boite_manuelle,
                $boite_automatique,
                $boite_robotisee
            );
            return view('pages.data.dataVoiture', compact('voitures'))->render();
        }
    }

    public function commentCaMarche()
    {
        return view('pages.faq');
    }

    public function contactezNous()
    {
        return view('pages.contact');
    }

    public function about()
    {
        return view('pages.about');
    }

    public function viewDetailsVoiture(Request $request)
    {

        $voiture = Voiture::where('id_voiture', decodeId($request->id_voiture))
            ->select('voitures.*', 'marques.*', 'modeles.*')
            ->join('marques', 'marques.id_marque', '=', 'voitures.marque_id')
            ->join('modeles', 'modeles.id_modele', '=', 'voitures.modele_id')
            ->first();

        $images = Image::where('voiture_id', decodeId($request->id_voiture))->orderByDesc('created_at')->get();
        $image_count = Image::where('voiture_id', decodeId($request->id_voiture))->count();
        // dump($voiture->id_voiture);
        // dump(decodeId($request->id_voiture));
        //dd($images);

        $voitures = Voiture::where('status_voiture', true)
            ->where('voitures.marque_id', $voiture->marque_id)
            ->select('voitures.*', 'marques.*', 'modeles.*')
            ->join('marques', 'marques.id_marque', '=', 'voitures.marque_id')
            ->join('modeles', 'modeles.id_modele', '=', 'voitures.modele_id')
            ->orderByDesc('voitures.created_at')
            ->limit(15)
            ->get();

        Session::put('details_url_previous', $request->url());

        $services = Service::where('status_service', true)->orderByDesc('services.created_at')->get();
        return view('pages.details', compact(['voiture', 'voitures', 'services', 'images', 'image_count']));
    }

    public function viewLogin(Request $request)
    {
        Session::put('details_url_previous', $request->url());
        return view('auth.login');
    }

    public function viewInscription()
    {
        return view('pages.inscription');
    }

    public function inscription(Request $request)
    {
        $messages = [
            "nom_user.required" => "Votre nom est requis",
            "nom_user.max" => "Votre nom est trop long",
            "prenom_user.required" => "Votre prenom est requis",
            "prenom_user.max" => "Votre prenom est trop long",
            "email_user.required" => "Votre adresse mail est requise",
            "email_user.email" => "Votre adresse mail est invalide",
            "email_user.max" => "Votre adresse mail est trop longue",
            "telephone_user.required" => "Votre numero de telephone est requis",
            "telephone_user.min" => "Votre numero de telephone est court",
            "adresse_user.required" => "Votre adresse de residense est requis",
            "adresse_user.max" => "Votre adresse de residense est trop long",
            "password.required" => "Le mot de passe est requis",
            "password.min" => "Le mot de passe est trop court",
            "password.same" => "Les mots de passes ne sont pas identiques",
        ];

        $validator = Validator::make($request->all(), [
            "nom_user" => "bail|required|max:50",
            "prenom_user" => "bail|required|max:50",
            "email_user" => "bail|required|email|max:50",
            "telephone_user" => "bail|required|min:8",
            "adresse_user" => "bail|required|max:50",
            "password" => "bail|required|min:8|same:confirmation_password",
        ], $messages);

        if ($validator->fails()) return response()->json([
            "status" => false,
            "reload" => false,
            "title" => "INSCRIPTION",
            "message" => $validator->errors()->first()
        ]);

        $client = new User();
        $client->code_user = "CLI-" . generateToken(6, DIGIT_TOKEN);
        $client->nom_user = $request->nom_user;
        $client->prenom_user = $request->prenom_user;
        $client->email_user = $request->email_user;
        $client->telephone_user = $request->telephone_user;
        $client->adresse_user = $request->adresse_user;
        $client->pays_user = $request->pays_user;
        $client->prefix_user = $request->prefix_user;
        $client->roles_user = "C01";
        $client->status_user = true;
        $client->password = Hash::make($request->password);
        $process = $client->save();

        //Enregistrement du systeme de log
        if ($process) saveSysActivityLog(SYS_LOG_SUCCESS, "Enregistrement du client " . $client->nom_user . " " . $client->prenom_user . " avec succes dans le système.", $client->id);
        else saveSysActivityLog(SYS_LOG_ERROR, "Echec d'enregistrement du client " . $client->nom_user . " " . $client->prenom_user . " avec succes dans le système.", $client->id);

        return response()->json([
            "status" => true,
            "reload" => false,
            "redirect_to" => route('login'),
            "title" => "INSCRIPTION",
            "message" => "Mr/Mlle " . $client->nom_user . " " . $client->prenom_user . " votre compte a été creeé avec succes"
        ]);
    }

    public function contactSendMail(Request $request)
    {
        $messages = [
            "nom.required" => "Le nom est requis pour l'envoie du message",
            "email.required" => "L'email est requis pour l'envoie du message",
            "email.email" => "L'email est invalide pour l'envoie du message",
            "sujet.required" => "Le sujet est requis pour l'envoie du message",
            "message.required" => "Le message est requis pour l'envoie du message",
        ];

        $validator = Validator::make($request->all(), [
            "nom" => "bail|required",
            "email" => "bail|required|email",
            "sujet" => "bail|required",
            "message" => "bail|required",
        ], $messages);

        if ($validator->fails()) return response([
            "status" => false,
            "reload" => false,
            "title" => "ENVOIE DU MESSAGE",
            "message" => $validator->errors()->first()
        ]);

        $data = [
            'nom' => $request->nom,
            'email' => $request->email,
            'sujet' => $request->sujet,
            'message' => $request->message,
        ];

        Mail::to('contact@mycartraders.com')
            ->send(new ContactezNous($data));

        return response()->json([
            "status" => true,
            "reload" => false,
            "redirect_to" => null,
            "title" => "ENVOIE DU MESSAGE",
            "message" => "Votre message a été envoyé avec succes"
        ]);
    }



    
}
