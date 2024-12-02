<?php

namespace App\Http\Controllers;

use App\Models\Verlof;
use App\Models\Status;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class VerlofController extends Controller
{
    /**
     * Toon een lijst van alle verlofrecords.
     */
    public function index()
    {
    // $verlof = DB::table('verlof')
    //     ->join('status', 'verlof.StatusID', '=', 'status.StatusID')
    //     ->select('verlof.*', 'status.Naam', 'status.Omschrijving')
    //     ->get();
    
    // // Gebruik één compact-aanroep met alle variabelen
    // return view('verlof.index', compact('verlof'));

    $verlofAanvragen = Verlof::all();
    return response()->json([
        "verlofaanvragen" => $verlofAanvragen,
        "message" => "enjoy"
    ]);

    }

    public function create()
    {
        $statussen = Status::all(); // Haal alle status-opties op
        return view('verlof.create'); // Zorg ervoor dat de verlof.create view bestaat
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'BeginTijd' => 'required|date_format:H:i',
            'BeginDatum' => 'required|date',
            'EindTijd' => 'required|date_format:H:i',
            'EindDatum' => 'required|date|after_or_equal:BeginDatum',
            'Reden' => 'required|string|max:255',
            'StatusID' => 'nullable|exists:status,StatusID',
        ]);

        // Maak een nieuw verlof record aan met de gevalideerde gegevens
        Verlof::create($validatedData);

        // Redirect terug naar de verlof index met een succesmelding
        // return redirect()->route('verlof.index')->with('success', 'Verlof succesvol aangemaakt.');
        return response()->json([
            'message' => 'Verlof successvol aangemaakt!',
        ], 201);

    }

}
