<?php

namespace App\Http\Controllers\Api;

use App\Models\Verlof;
use Illuminate\Http\Request;

class VerlofApiController
{
    /**
     * Display a listing of the resource.
     */
    // public function index()
    // {
    //     $verlofAanvragen = Verlof::with('user')->get();

    //     return view('verlof.verlofoverzicht', compact('verlofAanvragen'));
    
    //     // return response()->json([
    //     //     "verlofaanvragen" => $verlofAanvragen
    //     // ]);
    // }

    /**
     * Show an overview of all leave requests depending on who views the page.
     */
    
    public function verlofOverzicht(Request $request)
    {
        $status = $request->input('status', 'pending'); // Standaard filter op 'pending'
        $user = auth()->user(); // Haal de ingelogde gebruiker op

        // Controleer de rol en pas de query aan
        if ($user->rol === 'teammanager' || $user->rol === 'officemanager' ) {
            // Teammanagers zien alle aanvragen
            $verlofAanvragen = ($status == 'all') ? Verlof::all() : Verlof::where('status', $status)->get();
        } else {
            // Werknemers zien alleen hun eigen aanvragen
            $verlofAanvragen = ($status == 'all') 
                ? Verlof::where('user_id', $user->id)->get()
                : Verlof::where('user_id', $user->id)->where('status', $status)->get();
        }

        return view('verlof.verlofoverzicht', compact('verlofAanvragen', 'status'));
    }

    /**
     * return the form to create a new leave request, if the role is not 'werknemer'; return to dashboard.
     */

    public function create()
    {
        $user = auth()->user();
        if ($user->rol === 'werknemer') {
        return view('verlof.verlofaanvraag'); 
        }else{
            return redirect()->route('dashboard')->with('error', 'Je mag deze verlofaanvraag niet bewerken.');
        }
    }
    

    /**
     * Create a new leave request & send it to the database. Checks if the role is equal to 'werknemer', if not the user will be sent back to the dashboard.
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
    
        $user = auth()->user();
        if ($user->rol === 'werknemer') {
            $verlof = Verlof::create($validatedFields);
            return redirect()->route('verlofOverzicht');
        }else{
            return redirect()->route('dashboard')->withErrors(['error' => 'Je hebt geen toegang tot deze actie.']);;
        }
    
        // return response()->json([
        //     'message' => 'Verlof succesvol aangemaakt!',
        //     'verlof' => $verlof
        // ], 201);
    }
    

    /**
     * Display the specified resource with the corresponding user id. Checks if the user id matches that of the person who sent the request or if the user has an office/team manager role.
     */
    public function show(string $id)
    {
        $verlofAanvragen = Verlof::with('user')->findOrFail($id);
        $user = auth()->user(); 

        if ($verlofAanvragen->user_id === $user->id || $user->rol === 'teammanager' || $user->rol === 'officemanager') {
            
            return view('verlof.enkelVerlof', compact('verlofAanvragen'));
        }
        return redirect()->route('verlofOverzicht')->with('error', 'Je mag deze verlofaanvraag niet bewerken.');
    }

    /**
     * Set the status enum to 'approved'
     */

    public function approve($id)
    {
        $verlof = Verlof::findOrFail($id);
        $verlof->status = 'approved';
        $verlof->save();

        return redirect()->back()->with('success', 'Verlof is goedgekeurd.');
    }

    /**
     * Set the status enum to 'deny'
     */

    public function deny($id)
    {
        $verlof = Verlof::findOrFail($id);
        $verlof->status = 'denied';
        $verlof->save();

        return redirect()->back()->with('success', 'Verlof is afgewezen.');
    }


     /**
     * Redirect to the view where you can edit a leave request. Checks if the user id is the same as the person who requested leave.
     */
    public function updateview($id)
    {
        $verlofAanvragen = Verlof::findOrFail($id);
        $user = auth()->user(); 
    
        if ($verlofAanvragen->user_id !== $user->id) {
            return redirect()->route('verlofOverzicht')->with('error', 'Je mag deze verlofaanvraag niet bewerken.');
        }
    
        return view('verlof.verlofupdaten', compact('verlofAanvragen'));
    }

     /**
     * updates a leave request.
     */
    
    public function update(Request $request, $id)
    {
        $verlof = Verlof::findOrFail($id);
        
        $request->validate([
            'begin_tijd' => 'required',
            'begin_datum' => 'required|date',
            'eind_tijd' => 'required',
            'eind_datum' => 'required|date|after_or_equal:begin_datum',
            'reden' => 'required|string',
            'status' => 'required'
        ]);
    
        $verlof->update([
            'begin_tijd' => $request->begin_tijd,
            'begin_datum' => $request->begin_datum,
            'eind_tijd' => $request->eind_tijd,
            'eind_datum' => $request->eind_datum,
            'reden' => $request->reden,
            'status' => $request->status
        ]);
    
        return redirect()->route('verlofOverzicht')->with('success', 'Verlof succesvol bijgewerkt.');
    }
    

    /**
     * Removes the specified resource from the database.
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
