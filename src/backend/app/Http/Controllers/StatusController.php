<?php

namespace App\Http\Controllers;

use App\Models\Status;
use Illuminate\Http\Request;

class StatusController extends Controller
{
    public function index()
    {
        $statussen = Status::all();
        return response()->json([
            "Statussen" => $statussen,
            "message" => "Lijst statussen in json"
        ]);
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
    }

}
