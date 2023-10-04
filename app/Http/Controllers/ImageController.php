<?php

namespace App\Http\Controllers;

use App\Models\Image;
use App\Models\Voiture;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;

class ImageController extends Controller
{
    public function getImageVoiture()
    {
        $voitures = Voiture::where('status_voiture', true)
            ->select('voitures.*', 'marques.*', 'modeles.*', 'parkings.*', 'societes.*')
            ->join('marques', 'marques.id_marque', '=', 'voitures.marque_id')
            ->join('modeles', 'modeles.id_modele', '=', 'voitures.modele_id')
            ->join('parkings', 'parkings.id_parking', '=', 'voitures.parking_id')
            ->join('societes', 'societes.id_societe', '=', 'voitures.societe_id')
            ->orderByDesc('voitures.created_at')
            ->get();

        $images = Image::select('images.*', 'voitures.*', 'users.*', 'marques.*', 'modeles.*')
            ->join('voitures', 'voitures.id_voiture', '=', 'images.voiture_id')
            ->join('marques', 'marques.id_marque', '=', 'voitures.marque_id')
            ->join('modeles', 'modeles.id_modele', '=', 'voitures.modele_id')
            ->join('users', 'users.id', '=', 'images.created_by')
            ->orderByDesc('images.created_at')
            ->get();
        return view('packages.images.admin.image', compact(['voitures', 'images']));
    }

    public function infoImageVoiture(Request $request)
    {
        $image = Image::where('id_image', decodeId($request->id_image))
            ->select('images.*', 'voitures.*', 'users.*', 'marques.*', 'modeles.*', 'societes.*', 'parkings.*')
            ->join('voitures', 'voitures.id_voiture', '=', 'images.voiture_id')
            ->join('marques', 'marques.id_marque', '=', 'voitures.marque_id')
            ->join('modeles', 'modeles.id_modele', '=', 'voitures.modele_id')
            ->join('societes', 'societes.id_societe', '=', 'voitures.societe_id')
            ->join('parkings', 'parkings.id_parking', '=', 'societes.parking_id')
            ->join('users', 'users.id', '=', 'images.created_by')
            ->orderByDesc('images.created_at')
            ->first();
        return response()->json($image);
    }

    public function getSpecImageVoiture()
    {
    }

    public function storeImageVoiture(Request $request)
    {
        $messages = [
            "voiture.required" => "Veuillez selectionnez une voiture, svp",
            "imageFile.required" => "L'image de la voiture est requise",
            "imageFile.mimes" => "L'image de la voiture que vous avez selectionnez est invalide",
            "imageFile.max" => "L'image de la voiture est trop lourde",
        ];

        $validator = Validator::make($request->all(), [
            "voiture" => "bail|required",
            "imageFile" => "bail|required|mimes:jpeg,jpg,png|max:2048",
            "imageFile" => "bail|max:2048",
            "imageFile.*" => "bail|mimes:jpeg,jpg,png",
        ], $messages);

        if ($validator->fails()) return response()->json([
            "status" => false,
            "reload" => false,
            "title" => "ENREGISTREMENT DE L'IMAGE",
            "message" => $validator->errors()->first(),
        ]);

        $voiture = Voiture::where('id_voiture', $request->voiture)->first();

        if ($request->hasFile('imageFile')) {
            foreach ($request->file('imageFile') as $file) {
                $name = $file->getClientOriginalName();
                $file->move('storage/images', $name);

                $finalImage = new Image();
                $finalImage->voiture_id = $request->voiture;
                $finalImage->created_by = Auth::id();
                $finalImage->societe_id = $voiture->societe_id;
                $finalImage->path_image = '/storage/images/' . $name;

                $process = $finalImage->save();
            }

            //Enregistrement du systeme de log
            if ($process) saveSysActivityLog(SYS_LOG_SUCCESS, "Enregistrement de l'image de la voiture avec succes dans le système.", Auth::id());
            else saveSysActivityLog(SYS_LOG_ERROR, "Echec d'enregistrement de l'image de la voiture avec succes dans le système.", Auth::id());

            return response()->json([
                "status" => $process,
                "reload" => true,
                "title" => "ENREGISTREMENT DE L'IMAGE",
                "message" => "L'image de voiture a été ajoutée avec succes"
            ]);
        } else {
            return response()->json([
                "status" => false,
                "reload" => false,
                "title" => "ENREGISTREMENT DU PARC",
                "message" => "Une erreur s'est produite"
            ]);
        }
    }

    public function updateImageVoiture(Request $request)
    {
        $messages = [
            "image_voiture.required" => "L'image de la voiture est requise",
            "image_voiture.mimes" => "L'image de la voiture que vous avez selectionnez est invalide",
            "image_voiture.max" => "L'image de la voiture est trop lourde",
        ];

        $validator = Validator::make($request->all(), [
            "image_voiture" => "bail|required|mimes:jpeg,jpg,png|max:2048",
            "image_voiture" => "bail|max:2048",
            "image_voiture.*" => "bail|mimes:jpeg,jpg,png",
        ], $messages);

        if ($validator->fails()) return response()->json([
            "status" => false,
            "reload" => false,
            "title" => "MISE A JOUR DE L'IMAGE",
            "message" => $validator->errors()->first(),
        ]);

        $image = Image::findOrFail($request->id_image);

        if ($request->hasFile('image_voiture')) {
            $image_v = $request->image_voiture;
            $voiture_new_name = time() . '.' . $image_v->getClientOriginalExtension();
            $image_v->move('storage/uploads/', $voiture_new_name);
            $image->path_image = '/storage/uploads/' . $voiture_new_name;
        }

        $process = $image->save();

        //Enregistrement du systeme de log
        if ($process) saveSysActivityLog(SYS_LOG_SUCCESS, "Mise à jour de la voiture avec succes dans le système.", Auth::id());
        else saveSysActivityLog(SYS_LOG_ERROR, "Echec de mise à jour de la voiture avec succes dans le système.", Auth::id());

        return response()->json([
            "status" => $process,
            "reload" => false,
            "title" => "MISE A JOUR DE L'IMAGE",
            "message" => "L'image de la voiture a été modifiée avec succes"
        ]);
    }

    public function deleteImageVoiture(Request $request)
    {
        $image = Image::findOrFail($request->id_image);
        $cheminFinale = $image->path_image;
        unlink(public_path($cheminFinale));
        $process = $image->delete();

        //Enregistrement du systeme de log
        if ($process) saveSysActivityLog(SYS_LOG_SUCCESS, "Suppression de l'image de la voiture dans le système", Auth::id());
        else saveSysActivityLog(SYS_LOG_SUCCESS, "Suppression de l'image de la voiture dans le système", Auth::id());

        return response()->json([
            "status" => $process,
            "reload" => true,
            "title" => "SUPPRESSION DE L'IMAGE",
            "message" => "L'image de voiture a été bien supprimée dans le système"
        ]);
    }


    //================================================================================//
    // public function getSpecImageVoiture()
    // {
    //     $images = File::allFiles(public_path('storage/images'));
    //     $ouput = '<div class="row">';

    //     foreach ($images as $image) {
    //         $ouput .= '
    //             <div class="col-md-2" style="margin-bottom: 16px;" align="center">
    //                 <img src="' . asset('storage/images/' . $image->getFilename()) . '" height="175" width="175" style="height: 175px;"/>
    //                 <button type="submit" class="btn btn-danger remove_image mt-2" id="' . $image->getFilename() . '"><i class="bx bx-trash"></i> Supprimer</button>
    //             </div>
    //         ';
    //     }
    //     $ouput .= '</div>';
    //     echo $ouput;
    // }

    // public function storeImageVoiture(Request $request)
    // {
    //     $image = $request->file('file');
    //     $imageName = time() . '.' . $image->extension();
    //     $image->move(public_path('storage/images'), $imageName);
    //     return response()->json([
    //         "success" => $imageName
    //     ]);
    // }

    // public function deleteImageVoiture(Request $request)
    // {
    //     File::delete(public_path('storage/images/' . $request->get('name')));
    // }


    
}
