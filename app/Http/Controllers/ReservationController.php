<?php

namespace App\Http\Controllers;

use App\Models\Service;
use App\Models\Voiture;
use App\Models\Reservation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class ReservationController extends Controller
{
    public function getReservations()
    {
        $reservations = Reservation::where('status_annulation', false)
            ->where('status_reservation', true)
            ->select('reservations.*', 'voitures.*', 'societes.*', 'users.*', 'marques.*', 'modeles.*')
            ->join('voitures', 'voitures.id_voiture', '=', 'reservations.voiture_id')
            ->join('marques', 'marques.id_marque', '=', 'voitures.marque_id')
            ->join('modeles', 'modeles.id_modele', '=', 'voitures.modele_id')
            ->join('societes', 'societes.id_societe', '=', 'reservations.societe_id')
            ->join('users', 'users.id', '=', 'reservations.created_by')
            //->join('services', 'services.id_service', '=', 'reservations.service_reservation')
            ->orderByDesc('reservations.created_at')
            ->get();

        $listes_services = [];
        foreach ($reservations as $dataReservations) {
            $data = json_decode($dataReservations['service_reservation']);
            $nom_service = "";
            if (!is_null($data)) {
                foreach ($data as $item) {
                    $services = Service::where('id_service', $item)->first();
                    $nom_service .= $services->nom_service . ',';
                }
                $listes_services[$dataReservations->id_reservation] = $nom_service;
            } else {
                $listes_services[$dataReservations->id_reservation] = "";
            }
        }

        //Reservation annulee
        $reservations_annul = Reservation::where('status_annulation', true)
            ->select('reservations.*', 'voitures.*', 'societes.*', 'users.*', 'marques.*', 'modeles.*')
            ->join('voitures', 'voitures.id_voiture', '=', 'reservations.voiture_id')
            ->join('marques', 'marques.id_marque', '=', 'voitures.marque_id')
            ->join('modeles', 'modeles.id_modele', '=', 'voitures.modele_id')
            ->join('societes', 'societes.id_societe', '=', 'reservations.societe_id')
            ->join('users', 'users.id', '=', 'reservations.created_by')
            //->join('services', 'services.id_service', '=', 'reservations.service_reservation')
            ->orderByDesc('reservations.created_at')
            ->get();

        $listes_services_annul = [];
        foreach ($reservations_annul as $dataReservationsAnnul) {
            $data = json_decode($dataReservationsAnnul['service_reservation']);
            $nom_service = "";
            if (!is_null($data)) {
                foreach ($data as $item) {
                    $services = Service::where('id_service', $item)->first();
                    $nom_service .= $services->nom_service . ',';
                }
                $listes_services_annul[$dataReservationsAnnul->id_reservation] = $nom_service;
            } else {
                $listes_services_annul[$dataReservationsAnnul->id_reservation] = "";
            }
        }

        return view('packages.reservations.reservation', compact([
            'reservations', 'listes_services', 'reservations_annul',
            'listes_services_annul'
        ]));
    }

    public function listeReservation()
    {
        $client = Auth::user();
        $mes_reservations = Reservation::where('reservations.created_by', $client->id)
            ->where('status_reservation', true)
            ->select('reservations.*', 'voitures.*', 'marques.*', 'modeles.*')
            ->join('voitures', 'voitures.id_voiture', '=', 'reservations.voiture_id')
            ->join('marques', 'marques.id_marque', '=', 'voitures.marque_id')
            ->join('modeles', 'modeles.id_modele', '=', 'voitures.modele_id')
            ->orderByDesc('reservations.created_at')
            ->get();

        $listes_services = [];
        foreach ($mes_reservations as $dataReservations) {
            $data = json_decode($dataReservations['service_reservation']);
            $nom_service = "";
            if (!is_null($data)) {
                foreach ($data as $item) {
                    $services = Service::where('id_service', $item)->first();
                    $nom_service .= $services->nom_service . ',';
                }
                $listes_services[$dataReservations->id_reservation] = $nom_service;
            } else {
                $listes_services[$dataReservations->id_reservation] = "";
            }
        }

        return view('pages.utilisateur.reservation', compact([
            'mes_reservations', 'client', 'listes_services'
        ]));
    }

    public function infoReservation(Request $request)
    {
        $reservation = Reservation::where('id_reservation', decodeId($request->id_reservation))
            ->select('reservations.*', 'voitures.*', 'societes.*', 'parkings.*', 'users.*', 'marques.*', 'modeles.*')
            ->join('voitures', 'voitures.id_voiture', '=', 'reservations.voiture_id')
            ->join('marques', 'marques.id_marque', '=', 'voitures.marque_id')
            ->join('modeles', 'modeles.id_modele', '=', 'voitures.modele_id')
            ->join('societes', 'societes.id_societe', '=', 'reservations.societe_id')
            ->join('parkings', 'parkings.id_parking', '=', 'societes.parking_id')
            ->join('users', 'users.id', '=', 'reservations.created_by')
            ->orderByDesc('reservations.created_at')
            ->first();
        return response()->json($reservation);
    }

    public function storeReservation(Request $request)
    {
        $voiture = Voiture::where('id_voiture', decodeId($request->voiture))
            ->select('voitures.*', 'marques.*', 'modeles.*')
            ->join('marques', 'marques.id_marque', '=', 'voitures.marque_id')
            ->join('modeles', 'modeles.id_modele', '=', 'voitures.modele_id')
            ->first();

        $nom_produit = $voiture->nom_marque . " " . $voiture->nom_modele;

        $response = payWithPayDunya($nom_produit);

        if ($response->status == "success") {

            $reservation = new Reservation();
            $reservation->code_reservation = "RESERV-" . generateToken(8, DIGIT_TOKEN);
            $reservation->prix_reservation = 200;
            $reservation->service_reservation = json_encode($request->service);
            $reservation->status_reservation = false;
            $reservation->voiture_id = decodeId($request->voiture);
            $reservation->societe_id = decodeId($request->societe);
            $reservation->created_by = decodeId($request->client);
            $reservation->token_payement = $response->token;

            $process = $reservation->save();

            //Enregistrement du systeme de log
            if ($process) saveSysActivityLog(SYS_LOG_SUCCESS, "Enregistrement de la reservation avec succes dans le système.", $reservation->created_by);
            else saveSysActivityLog(SYS_LOG_ERROR, "Echec d'enregistrement de la reservation avec succes dans le système.", $reservation->created_by);

            return response()->json([
                "status" => true,
                "reload" => false,
                "redirect_to" => $response->getInvoiceUrl(),
                "title" => "PAYEMENT DE LA RESERVATION",
                "message" => "Veuillez patientez pour proceder au paiement."
            ]);
        }
    }

    public function annulationReservation(Request $request)
    {
        $messages = [
            "motif_reservation.required" => "Le motif de la reservation est requis",
            "motif_reservation.max" => "Le motif de la reservation est trop long",
        ];

        $validator = Validator::make($request->all(), [
            "motif_reservation" => "bail|required|max:255",
        ], $messages);

        if ($validator->fails()) return response()->json([
            "status" => false,
            "reload" => false,
            "redirect_to" => null,
            "title" => "ANNULATION D'UNE RESERVATION",
            "message" => $validator->errors()->first(),
        ]);

        $reservation = Reservation::findOrFail($request->reservation);
        $reservation->motif_reservation = $request->motif_reservation;
        $reservation->status_annulation = true;
        $process = $reservation->save();

        //Enregistrement du systeme de log
        if ($process) saveSysActivityLog(SYS_LOG_SUCCESS, "Annulation de la reservation avec succes dans le système.", Auth::id());
        else saveSysActivityLog(SYS_LOG_ERROR, "Echec d'annulation de la reservation avec succes dans le système.", Auth::id());

        return response()->json([
            "status" => true,
            "reload" => false,
            "redirect_to" => null,
            "title" => "ANNULATION D'UNE RESERVATION",
            "message" => "La reservation a été annulée avec succes"
        ]);
    }

    public function payementCallback()
    {
        $token = $_GET['token'];

        $reservation = Reservation::where('created_by', Auth::id())
            ->where('status_reservation', false)
            ->where('token_payement', $token)
            ->orderByDesc('id_reservation')->first();

        $voiture = Voiture::where('id_voiture', $reservation->voiture_id)->first();

        if ($reservation) {
            $response = checkEtatPayementPaydunya($token);
            $data = json_decode($response);

            if ($data->status == "cancelled") {
                $client = Auth::user();
                Session::flash('message_return', "Cette transaction a été annulée avec succes.");
                return view('pages.payement_return', compact('client'));
            } elseif ($data->status == "pending") {
                $client = Auth::user();
                Session::flash('message_return', "Cette transaction est en attente donc veuillez patientez un instant svp.");
                return view('pages.payement_return', compact('client'));
            } elseif ($data->status == "completed") {

                $reservation->status_reservation = true;
                $reservation->facture_reservation = $data->receipt_url;
                $process = $reservation->save();

                $voiture->status_reserver = true;
                $voiture->save();

                //Enregistrement du systeme de log
                if ($process) saveSysActivityLog(SYS_LOG_SUCCESS, "Enregistrement de la reservation avec succes dans le système.", $reservation->created_by);
                else saveSysActivityLog(SYS_LOG_ERROR, "Echec d'enregistrement de la reservation avec succes dans le système.", $reservation->created_by);

                $client = Auth::user();
                Session::flash('message_success', 'Le paiement de la reservation a été effectué avec succes');
                return view('pages.payement_callback', compact('client'));
            }
        } else {
            $client = Auth::user();
            Session::flash('message_return', "Cette transaction n'existe pas sur notre serveur.");
            return view('pages.payement_return', compact('client'));
        }
    }

    public function payementCancel()
    {
        $client = Auth::user();
        Session::flash('message_cancel', 'La reservation a ete annulee avec succes');
        return view('pages.payement_cancel', compact('client'));
    }

    public function payementReturn()
    {
        $token = $_GET['token'];

        $reservation = Reservation::where('created_by', Auth::id())
            ->where('status_reservation', false)
            ->where('token_payement', $token)
            ->orderByDesc('id_reservation')->first();

        $voiture = Voiture::where('id_voiture', $reservation->voiture_id)->first();

        if ($reservation) {
            $response = checkEtatPayementPaydunya($token);
            $data = json_decode($response);

            if ($data->status == "cancelled") {
                $client = Auth::user();
                Session::flash('message_return', "Cette transaction a été annulée avec succes.");
                return view('pages.payement_return', compact('client'));
            } elseif ($data->status == "pending") {
                $client = Auth::user();
                Session::flash('message_return', "Cette transaction est en attente donc veuillez patientez un instant svp.");
                return view('pages.payement_return', compact('client'));
            } elseif ($data->status == "completed") {

                $reservation->status_reservation = true;
                $reservation->facture_reservation = $data->receipt_url;
                $process = $reservation->save();

                $voiture->status_reserver = true;
                $voiture->save();

                //Enregistrement du systeme de log
                if ($process) saveSysActivityLog(SYS_LOG_SUCCESS, "Enregistrement de la reservation avec succes dans le système.", $reservation->created_by);
                else saveSysActivityLog(SYS_LOG_ERROR, "Echec d'enregistrement de la reservation avec succes dans le système.", $reservation->created_by);

                $client = Auth::user();
                Session::flash('message_success', 'Le paiement de la reservation a été effectué avec succes');
                return view('pages.payement_return', compact('client'));
            }
        } else {
            $client = Auth::user();
            Session::flash('message_return', "Cette transaction n'existe pas sur notre serveur.");
            return view('pages.payement_return', compact('client'));
        }
    }

    public function notificationPayement()
    {
        echo "Notification payement";
    }
}
