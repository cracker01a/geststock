<?php

namespace App\Http\Controllers;

use App\Models\Site;
use Illuminate\Http\Request;
use App\Models\User;


class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Récupérer tous les utilisateurs
        $users = User::all();

        // Passer les données à la vue
        return view('users.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $sites = Site::where('isActive', true)->get();
        return view('users.create' , compact('sites'));
    }




    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        $users = $request->user;
        $create = 0;

        foreach ($users as $user) {

            $firstname  = ($user['firstname']);
            $lastname  = ($user['lastname']);
            $email  = ($user['email']);
            $status  = ($user['status']);
            $isActive  = ($user['isActive']);
            $site_id  = ($user['site_id']);

            // dd($site_id);
            $create_user = User::create([
                'firstname' => $firstname,
                'lastname'   => $lastname,
                'email' => $email,
                'status' => $status,
                'isActive' => $isActive,
                'sites_id' => $site_id,
                'password' => null, // Le mot de passe est défini à null
            ]);

            if ($create_user) $create = $create + 1;

        }

        if (isset($create_user)) {
            return redirect()->route('users.index')->with(['success' => "Vous venez d'enregistrer ".$create." utilisateurs(s)."]);
        }else {
            return redirect()->route('users.index')->with(['error' => "Enregistrement echoué. Veuillez verifier vos informations saisies."]);
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
            // Récupérer l'utilisateur par son ID
        $user = User::findOrFail($id);
        $sites = Site::where('isActive', true)->get();

        // Passer les données à la vue d'édition
        return view('users.edit', compact('user' , 'sites'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
         // Validation des données
    $validated = $request->validate([
        'firstname' => 'required|string|max:255',
        'lastname' => 'required|string|max:255',
        'email' => 'required|email|unique:users,email,' . $id,
        'status' => 'required|string',
        'isActive' => 'required|boolean',
        'site_id' => 'required',
    ]);


    // Trouver l'utilisateur par son ID
    $user = User::findOrFail($id);

    // Mise à jour des informations de l'utilisateur
    $user->update([
        'firstname' => $validated['firstname'],
        'lastname' => $validated['lastname'],
        'email' => $validated['email'],
        'status' => $validated['status'],
        'isActive' => $validated['isActive'],
        'sites_id' => $validated['site_id'],
        // Le mot de passe n'est pas mis à jour ici, il reste null
    ]);

    return redirect()->route('users.index')->with('success', 'Utilisateur mis à jour avec succès.');
}

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
        {
            // Trouver l'utilisateur par son ID
        $user = User::findOrFail($id);

        // Supprimer l'utilisateur
        $user->delete();

        return redirect()->route('users.index')->with('success', 'Utilisateur supprimé avec succès.');
    }
}
