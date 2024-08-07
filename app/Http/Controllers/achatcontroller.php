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
        $products = Product::all();
        $sites = Site::where('isActive', true)->get();
        return view('achat.create', compact('sites','products'));
    }
    

    public function store(Request $request)
    {
        $achats = $request->achat;
        $create = 0;
    
        foreach ($achats as $achat) {
            // Préparation des données
            $site_id = $achat['site_id']; 
            $product_id = $achat['product_id']; 
            $quantity = (int)$achat['quantity']; 
            $users_id = Auth::id();
            $unit_price = (float)$achat['unit_price']; 
            $total_price = $quantity * $unit_price; 
    
            // Génération d'un numéro d'achat unique
            $numeroAchat = generateUniqueNumber('ACH-', Achat::class, 'numero_achat');
    
            // Création d'un nouvel achat
            $create_achat = Achat::create([
                'site_id' => $site_id,
                'product_id' => $product_id, 
                'quantity' => $quantity,
                'users_id' => $users_id,
                'unit_price' => $unit_price,
                'total_price' => $total_price,
                'numero_achat' => $numeroAchat,
            ]);
    
            if ($create_achat) {
                // Mise à jour de la quantité du produit
                $product = Product::find($product_id);
                if ($product) {
                    $product->quantity += $quantity; // Ajouter la quantité de l'achat à la quantité existante
                    $product->save(); // Sauvegarder les modifications dans la base de données
                }
    
                $create = $create + 1;
            }
        }
    
        if ($create > 0) {
            return redirect()->route('achat.index')->with(['success' => "Vous venez d'enregistrer ".$create." achat(s)."]);
        } else {
            return redirect()->route('achat.index')->with(['error' => "Enregistrement échoué. Veuillez vérifier vos informations saisies."]);
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
        $products = Product::all();
        return view('achat.edit', compact('achat', 'sites', 'products'));
    }

    /**
     * Update the specified resource in storage.
     */
    
     public function update(Request $request, Achat $achat)
     {
         // Règles de validation
         $rules = [
             'site_id' => 'required',
             'product_id' => 'required',
             'unit_price' => 'required|numeric',
             'quantity' => 'required|integer',
         ];
     
         $request->validate($rules);
     
         // Récupérer l'achat existant
         if ($achat) {
             // Récupérer le produit associé à l'achat
             $product = Product::find($achat->product_id);
     
             // Vérifier si le produit existe
             if (!$product) {
                 return redirect()->back()
                                  ->with('error', 'Le produit associé à cet achat n\'existe pas.');
             }
     
             // Quantité actuelle de l'achat et produit
             $currentQuantity = $achat->quantity;
             $currentProductQuantity = $product->quantity;
     
             // Nouvelle quantité à ajouter
             $newQuantity = $request->quantity;
     
             // Calculer la nouvelle quantité du produit
             $updatedProductQuantity = $currentProductQuantity - $currentQuantity + $newQuantity;
     
             // Mettre à jour la quantité du produit
             $product->quantity = $updatedProductQuantity;
             $product->save();
     
             // Vérifier si un autre achat avec les mêmes critères existe déjà
             $exist_achat = Achat::where('product_id', $request->product_id)
                                 ->where('site_id', $request->site_id)
                                 ->where('unit_price', $request->unit_price)
                                 ->where('quantity', $request->quantity)
                                 ->first();
     
             if ($exist_achat && $exist_achat->id != $achat->id) {
                 // Retourner à la page précédente avec un message d'erreur
                 return redirect()->back()
                                  ->with('error', 'Cet achat avec les mêmes détails existe déjà');
             }
     
             // Préparer les données pour la mise à jour
             $data = [
                 'site_id' => $request->site_id,
                 'product_id' => $request->product_id,
                 'unit_price' => $request->unit_price,
                 'quantity' => $request->quantity,
             ];
     
             // Mettre à jour l'achat
             $achat->update($data);
     
             return redirect()->route('achat.index')
                              ->with('success', 'Achat modifié avec succès');
         } else {
             return redirect()->route('achat.index')
                              ->with('error', 'Cet achat n\'existe pas');
         }
     }
     

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        // Récupérer l'achat à supprimer
        $achat = Achat::find($id);
    
        if ($achat) {
            // Récupérer le produit associé à cet achat
            $product = Product::find($achat->product_id);
    
            if ($product) {
                // Réduire la quantité du produit
                $product->quantity -= $achat->quantity; // Soustraire la quantité de l'achat
                $product->save(); // Sauvegarder les modifications
            }
    
            // Supprimer l'achat
            $achat->delete();
    
            return redirect()->route('achat.index')->with('success', 'Achat supprimé avec succès.');
        } else {
            return redirect()->route('achat.index')->with('error', 'Achat non trouvé.');
        }
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
