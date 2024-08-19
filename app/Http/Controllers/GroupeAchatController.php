<?php

namespace App\Http\Controllers;

use App\Models\GroupeAchat;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class GroupeAchatController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $group_achats = GroupeAchat::orderByDesc('created_at')->get();
        return view('achat.groupe.index' , compact('group_achats'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('achat.groupe.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $groupe_achats = $request->groupe_achat;
        $create = 0;

        foreach ($groupe_achats as $groupe) {

            if ($groupe['name']) {

                $name  = mb_strtoupper($groupe['name']);

                $create_groupe = GroupeAchat::create([
                    'name'      => strtoupper($name),
                    'users_id'  => Auth::id(),
                ]);

                if ($create_groupe) $create = $create + 1;

            }

        }

        if (isset($create_groupe)) {
            return redirect()->route('achat.groupe.index')->with(['success' => "Vous venez d'enregistrer ".$create." groupe(s)."]);
        }else {
            return redirect()->route('achat.groupe.index')->with(['info' => "Aucun groupe ajouté."]);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $groupe = GroupeAchat::find($id);
        return view('achat.groupe.edit' , compact('groupe'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $rules = [ 'name' => 'required|string' ];

        $request->validate($rules);

        $groupe = GroupeAchat::find($id);

        if($groupe){
            // Verify if new subcategorie already exists
            $exist_site = GroupeAchat::where('name', $request->name)->first();

            if($exist_site && $exist_site->id != $groupe->id){
                return redirect()->back()
                                ->with('error', 'Ce groupe existe déjà');
            }

            $data['name'] = $request->name;

            $groupe->update($data);

            return redirect()->route('achat.groupe.index')
                            ->with('success', 'Groupe modifiée avec succès');
        }else{
            return redirect()->route('achat.groupe.index')
                            ->with('error', 'Ce groupe n\'existe pas');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        if ($groupe = GroupeAchat::find($id)) {
            // Supprimer le groupe
            $groupe->delete();

            return redirect()->route('achat.groupe.index')->with('success', 'Groupe supprimé avec succès.');
        } else {
            return redirect()->route('achat.groupe.index')->with('error', 'Groupe non trouvé.');
        }
    }
}
