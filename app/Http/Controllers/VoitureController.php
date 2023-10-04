<?php

namespace App\Http\Controllers;

use App\Models\GestionnaireSociete;
use App\Models\Marque;
use App\Models\Modele;
use App\Models\Parking;
use App\Models\Societe;
use App\Models\Voiture;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class VoitureController extends Controller
{
    public function getVoiture()
    {
        $marques = Marque::where('status_marque', true)->get();
        $modeles = Modele::where('status_modele', true)->get();
        $societes = Societe::where('status_societe', true)->get();
        $parkings = Parking::where('status_parking', true)->get();
        $voitures = Voiture::where('status_vente', false)->orderByDesc('created_at')->get();
        $voitures_vendues = Voiture::where('status_vente', true)->orderByDesc('created_at')->get();
        return view('packages.voitures.admin.voiture', compact([
            'marques', 'modeles', 'voitures', 'parkings', 'societes', 'voitures_vendues'
        ]));
    }

    public function getSpecVoiture(Request $request): JsonResponse
    {
        $voiture = Voiture::find(decodeId($request->id_voiture));
        return response()->json(['data' => $voiture]);
    }

    public function infoVoiture(Request $request)
    {
        $voiture = Voiture::where('id_voiture', decodeId($request->id_voiture))
            ->select('voitures.*', 'marques.*', 'modeles.*', 'parkings.*', 'societes.*')
            ->join('marques', 'marques.id_marque', '=', 'voitures.marque_id')
            ->join('modeles', 'modeles.id_modele', '=', 'voitures.modele_id')
            ->join('parkings', 'parkings.id_parking', '=', 'voitures.parking_id')
            ->join('societes', 'societes.id_societe', '=', 'voitures.societe_id')
            ->first();
        return response()->json($voiture);
    }

    public function storeVoiture(Request $request)
    {
        $messages = [
            "marque_id.required" => "La marque de la voiture est requise",
            "modele_id.required" => "Le modele de la voiture est requis",
            "parking_id.required" => "Le parking de la voiture est requis",
            "annee_voiture.required" => "L'annee de la voiture est requise",
            "annee_voiture.max" => "L'annee de la voiture est trop longue",
            "kilometrage_voiture.required" => "Le kilometrage de la voiture est requis",
            "date_mise_circul_voiture.required" => "Date de mise en circulation de la voiture est requise",
            "carburant_voiture.required" => "Le carburant de la voiture est requis",
            "boite_vitesse_voiture.required" => "La boite de vitesse de la voiture est requise",
            "nbres_place_voiture.required" => "Le nombre de place de la voiture est requis",
            "interieur_voiture.required" => "L'interieur de la voiture est requis",
            "interieur_voiture.max" => "L'interieur de la voiture est trop long",
            "exterieur_voiture.required" => "L'exterieur de la voiture est requis",
            "exterieur_voiture.max" => "L'exterieur de la voiture est trop long",
            "puissance_voiture.required" => "La puissance de la voiture est requise",
            "puissance_voiture.max" => "La puissance de la voiture est trop long",
            "prix_voiture.required" => "Le prix de la voiture est requis",
            "image_voiture.required" => "L'image de la voiture est requise",
            "image_voiture.mimes" => "L'image de la voiture que vous avez selectionnez est invalide",
            "image_voiture.max" => "L'image de la voiture est trop lourde",
        ];

        $validator = Validator::make($request->all(), [
            "marque_id" => "bail|required",
            "modele_id" => "bail|required",
            "parking_id" => "bail|required",
            "annee_voiture" => "bail|required|max:255",
            "kilometrage_voiture" => "bail|required",
            "date_mise_circul_voiture" => "bail|required",
            "carburant_voiture" => "bail|required",
            "boite_vitesse_voiture" => "bail|required",
            "nbres_place_voiture" => "bail|required",
            "interieur_voiture" => "bail|required|max:255",
            "exterieur_voiture" => "bail|required|max:255",
            "puissance_voiture" => "bail|required|max:255",
            "prix_voiture" => "bail|required",
            "image_voiture" => "bail|required",
            "image_voiture" => "bail|max:2048",
            "image_voiture.*" => "bail|mimes:jpeg,jpg,png",
        ], $messages);

        if ($validator->fails()) return response()->json([
            "status" => false,
            "reload" => false,
            "title" => "ENREGISTREMENT DE LA VOITURE",
            "message" => $validator->errors()->first()
        ]);

        $marque = Marque::where('id_marque', decodeId($request->marque_id))->first();
        $modele = Modele::where('id_modele', $request->modele_id)->first();

        $voiture = new Voiture();
        $voiture->code_voiture = "VOITURE-" . generateToken(6, DIGIT_TOKEN);
        $voiture->slug_voiture = Str::slug($marque->nom_marque . "-" . $modele->nom_modele);
        $voiture->marque_id = decodeId($request->marque_id);
        $voiture->modele_id = $request->modele_id;
        $voiture->parking_id = decodeId($request->parking_id);
        $voiture->societe_id = $request->societe_id;
        $voiture->annee_voiture = $request->annee_voiture;
        $voiture->kilometrage_voiture = $request->kilometrage_voiture;
        $voiture->date_mise_circul_voiture = $request->date_mise_circul_voiture;
        $voiture->carburant_voiture = $request->carburant_voiture;
        $voiture->boite_vitesse_voiture = $request->boite_vitesse_voiture;
        $voiture->nbres_place_voiture = $request->nbres_place_voiture;
        $voiture->interieur_voiture = $request->interieur_voiture;
        $voiture->exterieur_voiture = $request->exterieur_voiture;
        $voiture->puissance_voiture = $request->puissance_voiture;
        $voiture->prix_voiture = $request->prix_voiture;
        $voiture->image_voiture = $request->image_voiture;
        $voiture->status_voiture = true;
        $voiture->status_vente = false;
        $voiture->created_by = Auth::id();

        if ($request->hasFile('image_voiture')) {
            $image = $request->image_voiture;
            $voiture_new_name = time() . '.' . $image->getClientOriginalExtension();
            $image->move('storage/uploads/', $voiture_new_name);
            $voiture->image_voiture = '/storage/uploads/' . $voiture_new_name;
        }

        $process = $voiture->save();

        //Enregistrement du systeme de log
        if ($process) saveSysActivityLog(SYS_LOG_SUCCESS, "Enregistrement de la voiture avec succes dans le système.", Auth::id());
        else saveSysActivityLog(SYS_LOG_ERROR, "Echec d'enregistrement de la voiture avec succes dans le système.", Auth::id());

        return response()->json([
            "status" => $process,
            "reload" => false,
            "title" => "ENREGISTREMENT DE LA VOITURE",
            "message" => "La voiture a été ajoutée avec succes"
        ]);
    }

    public function updateVoiture(Request $request)
    {
        $messages = [
            "marque__id.required" => "La marque de la voiture est requise",
            "modele__id.required" => "Le modele de la voiture est requis",
            "parking__id.required" => "Le parking de la voiture est requis",
            "annee_voiture.required" => "L'annee de la voiture est requise",
            "kilometrage_voiture.required" => "Le kilometrage de la voiture est requis",
            "date_mise_circul_voiture.required" => "Date de mise en circulation de la voiture est requise",
            "carburant_voiture.required" => "Le carburant de la voiture est requis",
            "boite_vitesse_voiture.required" => "La boite de vitesse de la voiture est requise",
            "nbres_place_voiture.required" => "Le nombre de place de la voiture est requis",
            "interieur_voiture.required" => "L'interieur de la voiture est requis",
            "interieur_voiture.max" => "L'interieur de la voiture est trop long",
            "exterieur_voiture.required" => "L'exterieur de la voiture est requis",
            "exterieur_voiture.max" => "L'exterieur de la voiture est trop long",
            "puissance_voiture.required" => "La puissance de la voiture est requise",
            "puissance_voiture.max" => "La puissance de la voiture est trop long",
            "prix_voiture.required" => "Le prix de la voiture est requis",
            "image_voiture.required" => "L'image de la voiture est requise",
            "image_voiture.mimes" => "L'image de la voiture que vous avez selectionnez est invalide",
            "image_voiture.max" => "L'image de la voiture est trop lourde",
        ];

        $validator = Validator::make($request->all(), [
            "marque__id" => "bail|required",
            "modele__id" => "bail|required",
            "parking__id" => "bail|required",
            "annee_voiture" => "bail|required",
            "kilometrage_voiture" => "bail|required",
            "date_mise_circul_voiture" => "bail|required",
            "carburant_voiture" => "bail|required",
            "boite_vitesse_voiture" => "bail|required",
            "nbres_place_voiture" => "bail|required",
            "interieur_voiture" => "bail|required|max:255",
            "exterieur_voiture" => "bail|required|max:255",
            "puissance_voiture" => "bail|required|max:255",
            "prix_voiture" => "bail|required",
            "image_voiture" => "bail|required",
            "image_voiture" => "bail|max:2048",
            "image_voiture.*" => "bail|mimes:jpeg,jpg,png",
        ], $messages);

        if ($validator->fails()) return response()->json([
            "status" => false,
            "reload" => false,
            "redirect_to" => null,
            "title" => "MISE A JOUR DE LA VOITURE",
            "message" => $validator->errors()->first()
        ]);

        $marque = Marque::where('id_marque', $request->marque__id)->first();
        $modele = Modele::where('id_modele', $request->modele__id)->first();

        $voiture = Voiture::findOrFail($request->id_voiture);
        $voiture->slug_voiture = Str::slug($marque->nom_marque . "-" . $modele->nom_modele);
        $voiture->marque_id = $request->marque__id;
        $voiture->modele_id = $request->modele__id;
        $voiture->parking_id = $request->parking__id;
        $voiture->societe_id = $request->societe__id;
        $voiture->annee_voiture = $request->annee_voiture;
        $voiture->kilometrage_voiture = $request->kilometrage_voiture;
        $voiture->date_mise_circul_voiture = $request->date_mise_circul_voiture;
        $voiture->carburant_voiture = $request->carburant_voiture;
        $voiture->boite_vitesse_voiture = $request->boite_vitesse_voiture;
        $voiture->nbres_place_voiture = $request->nbres_place_voiture;
        $voiture->interieur_voiture = $request->interieur_voiture;
        $voiture->exterieur_voiture = $request->exterieur_voiture;
        $voiture->puissance_voiture = $request->puissance_voiture;
        $voiture->prix_voiture = $request->prix_voiture;
        $voiture->status_voiture = $request->status_voiture;
        $voiture->status_vente = $request->status_vente;

        if ($request->hasFile('image_voiture')) {
            $image = $request->image_voiture;
            $voiture_new_name = time() . '.' . $image->getClientOriginalExtension();
            $image->move('storage/uploads/', $voiture_new_name);
            $voiture->image_voiture = '/storage/uploads/' . $voiture_new_name;
        }

        $process = $voiture->save();

        //Enregistrement du systeme de log
        if ($process) saveSysActivityLog(SYS_LOG_SUCCESS, "Mise à jour de la voiture " . $marque->nom_marque . " " . $modele->nom_modele . " avec succes dans le système.", Auth::id());
        else saveSysActivityLog(SYS_LOG_ERROR, "Echec de mise à jour de la voiture " . $marque->nom_marque . " " . $modele->nom_modele . " avec succes dans le système.", Auth::id());

        return response()->json([
            "status" => $process,
            "reload" => false,
            "title" => "MISE A JOUR DE LA VOITURE",
            "message" => "La voiture " . $marque->nom_marque . " " . $modele->nom_modele . " a été mise à jour avec succes"
        ]);
    }

    public function deleteVoiture(Request $request)
    {
        $voiture = Voiture::findOrFail($request->id_voiture);
        $cheminFinale = $voiture->image_voiture;
        unlink(public_path($cheminFinale));
        $process = $voiture->delete();

        //Enregistrement du systeme de log
        if ($process) saveSysActivityLog(SYS_LOG_SUCCESS, "Suppression de la voiture dans le système", Auth::id());
        else saveSysActivityLog(SYS_LOG_SUCCESS, "Suppression de la voiture dans le système", Auth::id());

        return response()->json([
            "status" => $process,
            "reload" => true,
            "title" => "SUPPRESSION DE LA VOITURE",
            "message" => "La voiture a été bien supprimée dans le système"
        ]);
    }
}
