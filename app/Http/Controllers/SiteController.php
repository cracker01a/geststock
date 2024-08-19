<?php

namespace App\Http\Controllers;

use App\Models\Site;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SiteController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $sites = Site::orderByDesc('created_at')->get();
        return view('site.index' , compact('sites'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('site.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $sites = $request->site;
        $create = 0;

        foreach ($sites as $site) {

            if ($site['name']) {

                $name  = mb_strtoupper($site['name']);

                $create_site = Site::create([
                    'name'      => strtoupper($name),
                    // 'users_id'  => Auth::id(),
                ]);

                if ($create_site) $create = $create + 1;

            }

        }

        if (isset($create_site)) {
            return redirect()->route('site.index')->with(['success' => "Vous venez d'enregistrer ".$create." site(s)."]);
        }else {
            return redirect()->route('site.index')->with(['error' => "Enregistrement echoué. Veuillez verifier vos informations saisies."]);
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
    public function edit(Site $site)
    {
        return view('site.edit' , compact('site'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Site $site)
    {
        $rules = [ 'name' => 'required|string' ];

        $request->validate($rules);

        if($site){
            // Verify if new subcategorie already exists
            $exist_site = Site::where('name', $request->name)->first();

            if($exist_site && $exist_site->id != $site->id){
                return redirect()->back()
                                ->with('error', 'Ce site existe déjà');
            }

            $data['name'] = $request->name;

            $site->update($data);

            return redirect()->route('site.index')
                            ->with('success', 'Produit modifiée avec succès');
        }else{
            return redirect()->route('site.index')
                            ->with('error', 'Ce produit n\'existe pas');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    public function enabled($id){

        $site = Site::find($id);
        $isActive = $site->isActive  ? 0 : 1;
        $site->isActive = $isActive;
        $site->save();
        $message = $site->isActive ? "Site activé" : "Site désactivé";

        return redirect()->back()->with('success', $message);

    }
}
