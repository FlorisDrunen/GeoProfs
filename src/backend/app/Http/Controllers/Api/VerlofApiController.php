<?php

namespace App\Http\Controllers\Api;

use App\Models\Verlof;
use Illuminate\Http\Request;

class VerlofApiController
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $verlofAanvragen = Verlof::with('user')->get();

        return view('verlof.verlofoverzicht', compact('verlofAanvragen'));
    
        // return response()->json([
        //     "verlofaanvragen" => $verlofAanvragen
        // ]);
    }
    

    public function create()
    {
        return view('verlof.verlofaanvraag'); 
    }
    

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedFields = $request->validate([
            'user_id' => 'required|exists:users,id',
            'begin_tijd' => 'required|date_format:H:i',
            'begin_datum' => 'required|date|date_format:Y-m-d|after_or_equal:today',
            'eind_tijd' => 'required|date_format:H:i',
            'eind_datum' => 'required|date|date_format:Y-m-d|after_or_equal:begin_datum',
            'reden' => 'required',
            'status' => 'required'
        ]);
    
        $verlof = Verlof::create($validatedFields);
        return redirect()->route('verlofOverzicht');
    
        // return response()->json([
        //     'message' => 'Verlof succesvol aangemaakt!',
        //     'verlof' => $verlof
        // ], 201);
    }
    

    /**
     * Display the specified resource.
     */
public function show(string $id)
{
    $verlofAanvragen = Verlof::with('user')->findOrFail($id);

    if (!$verlofAanvragen) {
        return redirect()->route('verlofOverzicht')->with('error', 'Verlofaanvraag niet gevonden.');
    }else{
        return view('verlof.enkelVerlof', compact('verlofAanvragen'));
    }

}

    public function approve($id)
    {
        $verlof = Verlof::findOrFail($id);
        $verlof->status = 'approved';
        $verlof->save();

        return redirect()->back()->with('success', 'Verlof is goedgekeurd.');
    }

    public function deny($id)
    {
        $verlof = Verlof::findOrFail($id);
        $verlof->status = 'denied';
        $verlof->save();

        return redirect()->back()->with('success', 'Verlof is afgewezen.');
    }


    public function updateview($id)
    {
        $verlofAanvragen = Verlof::findOrFail($id);
        return view('verlof.verlofupdaten', compact('verlofAanvragen'));
    }    

    public function update(Request $request, $id)
    {
        $verlof = Verlof::findOrFail($id);
        
        $request->validate([
            'begin_tijd' => 'required',
            'begin_datum' => 'required|date',
            'eind_tijd' => 'required',
            'eind_datum' => 'required|date|after_or_equal:begin_datum',
            'reden' => 'required|string',
        ]);
    
        $verlof->update([
            'begin_tijd' => $request->begin_tijd,
            'begin_datum' => $request->begin_datum,
            'eind_tijd' => $request->eind_tijd,
            'eind_datum' => $request->eind_datum,
            'reden' => $request->reden,
        ]);
    
        return redirect()->route('verlofOverzicht')->with('success', 'Verlof succesvol bijgewerkt.');
    }
    

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, string $id)
    {
        $verlof = Verlof::findOrFail($id);
        // if($request->user->id != $verlof->user_id){
        //     return 'failed';
        // }

        Verlof::destroy($id);
        return redirect()->route('verlofOverzicht');

        // return response()->json([
        //     'message' => 'data destroyed'
        // ]);
    }
}
