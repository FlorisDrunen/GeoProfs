<?php

namespace app\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Status;
use App\Models\Verlof;
use Illuminate\Http\Request;


class VerlofController extends Controller
{
    /**
     * Toon een lijst van alle verlofrecords.
     */
    public function index()
    {

    $verlofAanvragen = Verlof::all();
    return response()->json([
        "verlofaanvragen" => $verlofAanvragen
    ]);

    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'user_id' => 'required|exists:users,id',
            'begin_tijd' => 'required|date_format:H:i',
            'begin_datum' => 'required|date|after_or_equal:today',
            'eind_tijd' => 'required|date_format:H:i',
            'eind_datum' => 'required|date|after_or_equal:begin_datum',
            'reden' => 'required',
            'status' => 'required'
        ]);

        // Maak een nieuw verlof record aan met de gevalideerde gegevens
        Verlof::create($validatedData);

        return response()->json([
            'message' => 'Verlof successvol aangemaakt!',
        ], 201);
    }
}
