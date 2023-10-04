<?php

namespace App\Models;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Voiture extends Model
{
    use HasFactory;

    protected $table = 'voitures';
    protected $primaryKey = 'id_voiture';
    protected $guarded = ['created_at', 'updated_at'];

    public static function getAllVoitures(
        $search_keyword,
        $search_price_min = null,
        $search_price_max = null,
        $search_marque = null,
        $search_modele = null,
        $search_kilo_min = null,
        $search_kilo_max = null,
        $search_annee_min = null,
        $search_annee_max = null,
        $search_carburant_diesel = null,
        $search_carburant_essence = null,
        $search_carburant_hybride = null,
        $search_carburant_electrique = null,
        $search_carburant_glp = null,
        $search_carburant_gnv = null,
        $search_boite_manuelle = null,
        $search_boite_automatique = null,
        $search_boite_robotisee = null
    ) {
        // $voitures = Voiture::where('status_voiture', true)
        //     ->select('voitures.*', 'marques.*', 'modeles.*', 'parkings.*', 'societes.*')
        //     ->join('marques', 'marques.id_marque', '=', 'voitures.marque_id')
        //     ->join('modeles', 'modeles.id_modele', '=', 'voitures.modele_id')
        //     ->join('parkings', 'parkings.id_parking', '=', 'voitures.parking_id')
        //     ->join('societes', 'societes.id_societe', '=', 'voitures.societe_id')
        //     ->orderByDesc('voitures.created_at')
        //     ->paginate(15);

        $voitures = DB::table('voitures')
            ->where('status_voiture', true)
            ->where('status_vente', false)
            ->select('voitures.*', 'marques.*', 'modeles.*')
            ->join('marques', 'marques.id_marque', '=', 'voitures.marque_id')
            ->join('modeles', 'modeles.id_modele', '=', 'voitures.modele_id')
            ->orderByDesc('voitures.created_at');

        if ($search_keyword && !empty($search_keyword)) {
            $voitures->where(function ($c) use ($search_keyword) {
                $c->where('marques.nom_marque', 'like', "%{$search_keyword}%")
                    ->orWhere('modeles.nom_modele', 'like', "%{$search_keyword}%")
                    ->orWhere('voitures.carburant_voiture', 'like', "%{$search_keyword}%")
                    ->orWhere('voitures.interieur_voiture', 'like', "%{$search_keyword}%")
                    ->orWhere('voitures.exterieur_voiture', 'like', "%{$search_keyword}%")
                    ->orWhere('voitures.kilometrage_voiture', 'like', "%{$search_keyword}%")
                    ->orWhere('voitures.boite_vitesse_voiture', 'like', "%{$search_keyword}%")
                    ->orWhere('voitures.annee_voiture', 'like', "%{$search_keyword}%")
                    ->orWhere('voitures.nbres_place_voiture', 'like', "%{$search_keyword}%")
                    ->orWhere('voitures.date_mise_circul_voiture', 'like', "%{$search_keyword}%")
                    ->orWhere('voitures.puissance_voiture', 'like', "%{$search_keyword}%");
            });
        }

        if ($search_price_min && !empty($search_price_min)) {
            if ($search_price_max && !empty($search_price_max)) {
                $voitures->where(function ($c) use ($search_price_min) {
                    $c->where('voitures.prix_voiture', '>=', $search_price_min);
                });
                $voitures->where(function ($c) use ($search_price_max) {
                    $c->where('voitures.prix_voiture', '<=', $search_price_max);
                });
            }
        }

        // if ($search_price_max && !empty($search_price_max)) {
        //     $voitures->where(function ($c) use ($search_price_max) {
        //         $c->where('voitures.prix_voiture', '<=', $search_price_max);
        //     });
        // }

        if ($search_marque && !empty($search_marque)) {
            $voitures->where(function ($c) use ($search_marque) {
                $c->whereIN('voitures.marque_id', explode(",", $search_marque));
            });
        }

        if ($search_modele && !empty($search_modele)) {
            $voitures->where(function ($c) use ($search_modele) {
                $c->whereIN('voitures.modele_id', explode(",", $search_modele));
            });
        }

        if ($search_kilo_min && !empty($search_kilo_min)) {
            if ($search_kilo_max && !empty($search_kilo_max)) {
                $voitures->where(function ($c) use ($search_kilo_min) {
                    $c->orWhere('voitures.kilometrage_voiture', '>=', $search_kilo_min);
                });
                $voitures->where(function ($c) use ($search_kilo_max) {
                    $c->orWhere('voitures.kilometrage_voiture', '<=', $search_kilo_max);
                });
            }
        }

        // if ($search_kilo_max && !empty($search_kilo_max)) {
        //     $voitures->where(function ($c) use ($search_kilo_max) {
        //         $c->orWhere('voitures.kilometrage_voiture', '<=', $search_kilo_max);
        //     });
        // }

        if ($search_annee_min && !empty($search_annee_min)) {
            if ($search_annee_max && !empty($search_annee_max)) {
                $voitures->where(function ($c) use ($search_annee_min) {
                    $c->orWhere('voitures.annee_voiture', '>=', $search_annee_min);
                });
                $voitures->where(function ($c) use ($search_annee_max) {
                    $c->orWhere('voitures.annee_voiture', '<=', $search_annee_max);
                });
            }
        }

        // if ($search_annee_max && !empty($search_annee_max)) {
        //     $voitures->where(function ($c) use ($search_annee_max) {
        //         $c->orWhere('voitures.annee_voiture', '<=', $search_annee_max);
        //     });
        // }

        if ($search_carburant_diesel && !empty($search_carburant_diesel)) {
            $voitures->where(function ($c) use ($search_carburant_diesel) {
                $c->orWhere('voitures.carburant_voiture', '=', $search_carburant_diesel);
            });
        }

        if ($search_carburant_essence && !empty($search_carburant_essence)) {
            $voitures->where(function ($c) use ($search_carburant_essence) {
                $c->orWhere('voitures.carburant_voiture', '=', $search_carburant_essence);
            });
        }

        if ($search_carburant_hybride && !empty($search_carburant_hybride)) {
            $voitures->where(function ($c) use ($search_carburant_hybride) {
                $c->orWhere('voitures.carburant_voiture', '=', $search_carburant_hybride);
            });
        }

        if ($search_carburant_electrique && !empty($search_carburant_electrique)) {
            $voitures->where(function ($c) use ($search_carburant_electrique) {
                $c->orWhere('voitures.carburant_voiture', '=', $search_carburant_electrique);
            });
        }

        if ($search_carburant_glp && !empty($search_carburant_glp)) {
            $voitures->where(function ($c) use ($search_carburant_glp) {
                $c->orWhere('voitures.carburant_voiture', '=', $search_carburant_glp);
            });
        }

        if ($search_carburant_gnv && !empty($search_carburant_gnv)) {
            $voitures->where(function ($c) use ($search_carburant_gnv) {
                $c->orWhere('voitures.carburant_voiture', '=', $search_carburant_gnv);
            });
        }

        if ($search_boite_manuelle && !empty($search_boite_manuelle)) {
            $voitures->where(function ($c) use ($search_boite_manuelle) {
                $c->orWhere('voitures.boite_vitesse_voiture', '=', $search_boite_manuelle);
            });
        }

        if ($search_boite_automatique && !empty($search_boite_automatique)) {
            $voitures->where(function ($c) use ($search_boite_automatique) {
                $c->orWhere('voitures.boite_vitesse_voiture', '=', $search_boite_automatique);
            });
        }

        if ($search_boite_robotisee && !empty($search_boite_robotisee)) {
            $voitures->where(function ($c) use ($search_boite_robotisee) {
                $c->orWhere('voitures.boite_vitesse_voiture', '=', $search_boite_robotisee);
            });
        }

        return $voitures->paginate(15);
    }

    public function marques()
    {
        return $this->belongsTo(Marque::class, 'marque_id');
    }

    public function modeles()
    {
        return $this->belongsTo(Modele::class, 'modele_id');
    }

    public function parkings()
    {
        return $this->belongsTo(Parking::class, 'parking_id');
    }
}
