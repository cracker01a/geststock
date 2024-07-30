<?php

namespace App\Http\Controllers;


use App\Models\Product;
use App\Models\Site;
use App\Models\Achat;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class achatcontroller extends Controller
{
 /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $achats = Achat::with('site')->orderByDesc('created_at')->get();
        return view('achat.index', compact('achats'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $sites = Site::where('isActive', true)->get();
        return view('achat.create', compact('sites'));
    }
    

    public function store(Request $request)
    {
        $achats = $request->achat;
        $create = 0;

        foreach ($achats as $achat) {
            // Préparation des données
            $site_id = $achat['site_id']; 
            $quantity = (int)$achat['quantity']; 
            $users_id = Auth::id();
            $unit_price = (float)$achat['unit_price']; 
            $total_price = $quantity * $unit_price; 
          
        
            // Création d'un nouvel achat
            $create_achat = Achat::create([
                'site_id' => $site_id,
                'designation' => mb_strtoupper($achat['designation']),
                'quantity' => $quantity,
                'users_id' => $users_id,
                'unit_price' => $unit_price,
                'total_price' => $total_price,
               
            ]);
            if ($create_achat) $create = $create + 1;

        }

        if (isset($create_achat)) {
            return redirect()->route('achat.index')->with(['success' => "Vous venez d'enregistrer ".$create." achat(s)."]);
        }else {
            return redirect()->route('achat.index')->with(['error' => "Enregistrement echoué. Veuillez verifier vos informations saisies."]);
        }
    }
    /**
     * Display the specified resource.
     */
    public function show(Achat $achat)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Achat $achat)
    {
        $sites = Site::all();
        return view('achat.edit', compact('achat', 'sites'));
    }

    /**
     * Update the specified resource in storage.
     */
    
    public function update(Request $request, Achat $achat)
    {
        
        $rules = [
            'site_id' => 'required|',
            'designation' => 'required|string',
            'unit_price' => 'required|numeric',
            'quantity' => 'required|integer',
            
           
            
        ];

        $request->validate($rules);

        

        if($achat){
            // Verify if new subcategorie already exists
            $exist_achat = Achat::where('designation', $request->designation)->first();

            if($exist_achat && $exist_achat->id != $achat->id){
                return redirect()->back()
                                ->with('error', 'Ce achat existe déjà');
            }

        
            $data['site_id'] = $request->site_id;
            $data['designation'] = $request->designation;
            $data['unit_price'] = $request->unit_price;
            $data['quantity'] = $request->quantity;
            

            $achat->update($data);

            return redirect()->route('achat.index')
                            ->with('success', 'achat modifiée avec succès');
        }else{
            return redirect()->route('achat.index')
                            ->with('error', 'Cet achat n\'existe pas');
        }
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $achat = Achat::find($id);
        $achat->delete();
       


        return redirect()->route('achat.index')->with('success', 'Achat supprimé avec succès.');
    }

    /**
     * Toggle the activation status of the specified resource.
     */
    public function enabled($id)
    {
        $achat = Achat::find($id);
        $isActive = $achat->status ? 0 : 1;
        $achat->status = $isActive;
        $achat->save();
        $message = $achat->status ? "Achat validé" : "Achat non validé";

        return redirect()->back()->with('success', $message);
    }
}
