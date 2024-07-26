<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Site;

class SiteController extends Controller
{

    public function index()
    {
        $sites = Site::paginate(10);
        return view('layouts.sites', compact('sites'));
    }
    public function index1()
    {
        $sites = Site::paginate(10);
        return view('layouts.edit', compact('sites'));
    }
   // Afficher le formulaire d'édition pour un site spécifique
   public function edit($id)
   {
       $site = Site::findOrFail($id);
       return view('layouts.edit', compact('site'));
   }

   // Mettre à jour les informations du site
   public function update(Request $request, $id)
   {
       $site = Site::findOrFail($id);
       $site->update($request->all());

       return redirect()->route('sites')->with('success', 'Site updated successfully');
    }   
    public function destroy(Site $site)
    {
        $site->delete();
        return redirect()->route('sites')->with('success', 'Site supprimé avec succès.');
    }

          
    // Traite les données envoyées par le formulaire et ajoute le site à la base de données
    public function store(Request $request)
    {
        // Validation des données
        $request->validate([
            'name' => 'required|string|max:255',
            'address' => 'required|string|max:255',
            'status' => 'required|in:actif,inactif',
        ]);

        // Création du site
        Site::create([
            'name' => $request->input('name'),
            'address' => $request->input('address'),
            'status' => $request->input('status'),
        ]);

        // Redirection avec message de succès
        return redirect()->route('sites')->with('success', 'Site ajouté avec succès !');
    }
            public function updateStatus(Request $request, $id)
        {
            $request->validate([
                'status' => 'required|in:actif,inactif',
            ]);

            $site = Site::findOrFail($id);
            $site->status = $request->input('status');
            $site->save();

            return response()->json(['success' => true]);
        }
  

        
}
