<?php

namespace App\Http\Controllers;


use App\Models\GroupeVente;
use App\Models\user;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
class GroupeVenteController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // $group_achats = GroupeAchat::orderByDesc('created_at')->get();
        // Récupérer les groupes d'achat créés par l'utilisateur authentifié
        // $group_ventes = GroupeVente::where('users_id', Auth::id())
        // ->orderByDesc('created_at')
        // ->get();
        $group_ventes = GroupeVente::with('ventes.product', 'ventes.site', 'ventes.user', 'ventes.groupeVente')
        ->where('users_id', Auth::id())
        ->orderByDesc('created_at')
        ->get();

    return view('ventes.groupe.index', compact('group_ventes'));

       
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('ventes.groupe.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $groupe_ventes = $request->groupe_vente;
        $create = 0;

          // Récupérer l'utilisateur authentifié
             $user = Auth::user();
             $siteId = $user->sites_id;
        foreach ($groupe_ventes as $groupe) {

            if ($groupe['name']) {

                $name  = mb_strtoupper($groupe['name']);
              
                $create_groupe = GroupeVente::create([
                    'name'      => strtoupper($name),
                    'users_id'  => Auth::id(),
                
                    'sites_id'  => $siteId, // Récupérer le site_id de l'utilisateur
                   
                ]);
        
                if ($create_groupe) $create = $create + 1;

            }

        }

        if (isset($create_groupe)) {
            return redirect()->route('groupe_ventes.index')->with(['success' => "Vous venez d'enregistrer ".$create." groupe(s)."]);
        }else {
            return redirect()->route('groupe_ventes.index')->with(['info' => "Aucun groupe ajouté."]);
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
        $groupe = GroupeVente::find($id);
        return view('Ventes.groupe.edit' , compact('groupe'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $rules = [ 'name' => 'required|string' ];

        $request->validate($rules);

        $groupe = GroupeVente::find($id);

        if($groupe){
            // Verify if new subcategorie already exists
            $exist_site = GroupeVente::where('name', $request->name)->first();

            if($exist_site && $exist_site->id != $groupe->id){
                return redirect()->back()
                                ->with('error', 'Ce groupe existe déjà');
            }

            $data['name'] = $request->name;

            $groupe->update($data);

            return redirect()->route('groupe_ventes.index')
                            ->with('success', 'Groupe modifiée avec succès');
        }else{
            return redirect()->route('groupe_ventes.index')
                            ->with('error', 'Ce groupe n\'existe pas');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        if ($groupe = GroupeVente::find($id)) {
            // Supprimer le groupe
            $groupe->delete();

            return redirect()->route('groupe_ventes.index')->with('success', 'Groupe supprimé avec succès.');
        } else {
            return redirect()->route('groupe_ventes.index')->with('error', 'Groupe non trouvé.');
        }
    }
}
