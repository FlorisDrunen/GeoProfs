<?php

namespace app\Http\Controllers\Api;

use App\Models\Verlof;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;


class VerlofController extends Controller
{
    public function index()
    {
        $verlofAanvragen = Verlof::all();

        return response()->json([
            "verlofaanvragen" => $verlofAanvragen
        ]);
    }

    public function store(Request $request)
    {
        $validatedFields = $request->validate([
            //'user_id' => 'required|exists:users,id',
            'user_id' => 'required',
            'begin_tijd' => 'required|date_format:H:i',
            'begin_datum' => 'required|date|date_format:Y-m-d|after_or_equal:today',
            'eind_tijd' => 'required|date_format:H:i',
            'eind_datum' => 'required|date|date_format:Y-m-d|after_or_equal:begin_datum',
            'reden' => 'required',
            'status' => 'required'
        ]);

        $verlof = Verlof::create($validatedFields);

        return response()->json([
            'message' => 'Verlof successvol aangemaakt!',
            'verlof' => $verlof
        ], 201);
    }
}
