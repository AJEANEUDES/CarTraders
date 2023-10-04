<?php

namespace App\Http\Controllers\Gestionnaire;

use App\Models\Societe;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ParkingController extends Controller
{
    public function getSpecParkingVoiture(Request $request)
    {
        $societe = Societe::where('parking_id', decodeId($request->parking_id))->first();
        return response()->json($societe);
    }
}
