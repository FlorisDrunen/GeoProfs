<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class StatusController extends Controller
{
     /**
     * Toon een lijst van alle verlofrecords.
     */
    public function index()
    {

    }

    public function create()
    {

    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'Naam' => 'required|string|max:255',
            'Omschrijving' => 'required|string|max:255',

        ]);

        // Maak een nieuw verlof record aan met de gevalideerde gegevens
        Verlof::create($validatedData);

    }

}
