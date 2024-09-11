<?php

namespace App\Http\Controllers;


use App\Models\Product;
use App\Models\Site;
use App\Models\Achat;
use App\Models\GroupeAchat;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class Achatcontroller extends Controller
{
 /**
     * Display a listing of the resource.
     */
    public function index()
    {

        // Récupérer le site_id de l'utilisateur authentifié
        // $sites_id = Auth::user()->sites_id;

        // // Récupérer les achats liés à ce site
        // $achats = Achat::where('sites_id', $sites_id)
        //             ->with('site')
        //             ->orderByDesc('created_at')
        //             ->get();

            // $achats = Achat::with('site')->orderByDesc('created_at')->get();
            $sites = Site::where('isActive', true)->get();
        // $achats = Achat::orderByDesc('created_at')->get();
        // $sites = Site::where('isActive', true)->get();

        return view('achat.index',  compact('sites'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $user = Auth::user();



        $siteId = $user->sites_id;

        // Filtrer les produits en fonction du site_id
        $products = Product::where('sites_id', $siteId)->get();
        //  dd($siteId);
        $sites = Site::where('isActive', true)->get();
        $siteId = $user->site_id;
        // $groupes = GroupeAchat::orderByDesc('created_at')->get();
        // Récupérer les groupes d'achat créés par l'utilisateur authentifié
        $groupes = GroupeAchat::where('users_id', Auth::id())
        ->orderByDesc('created_at')
        ->get();

        return view('achat.create', compact('sites','products' , 'groupes'));

    }


    public function store(Request $request)
    {
        // $user = Auth::user();
        // $siteId = $user->sites_id;
        $achats = $request->achat;
        $create = 0;

        foreach ($achats as $achat) {
            // Préparation des données
            $site_id = $achat['site_id'];
            $product_id = $achat['product_id'];
            $quantity = (int)$achat['quantity'];
            $users_id = Auth::id();
            $unit_price = (float)$achat['unit_price'];
            $date_achat = $achat['date_achat'];
            $groupe_achats_id = $achat['groupe_achats_id'];
            $total_price = $quantity * $unit_price;

            // Génération d'un numéro d'achat unique
            $numeroAchat = generateUniqueNumber('ACH-', Achat::class, 'numero_achat');
            // dd($site_id);
            // Création d'un nouvel achat
            $create_achat = Achat::create([
                'sites_id' => $site_id,
                'products_id' => $product_id,
                'quantity' => $quantity,
                'users_id' => $users_id,
                'unit_price' => $unit_price,
                'total_price' => $total_price,
                'numero_achat' => $numeroAchat,
                'date_achat' => $date_achat,
                'groupe_achats_id' => $groupe_achats_id
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
        $user = Auth::user();



        $siteId = $user->sites_id;

        // Filtrer les produits en fonction du site_id
        $products = Product::where('sites_id', $siteId)->get();
        
        //  dd($siteId);
        $sites = Site::where('isActive', true)->get();
        $siteId = $user->site_id;
        // $groupes = GroupeAchat::orderByDesc('created_at')->get();
        // Récupérer les groupes d'achat créés par l'utilisateur authentifié
        $groupes = GroupeAchat::where('users_id', Auth::id())
        ->orderByDesc('created_at')
        ->get();

        return view('achat.edit', compact('achat', 'sites', 'products','groupes'));
    }

    /**
     * Update the specified resource in storage.
     */

     public function update(Request $request, Achat $achat)
     {
         // Règles de validation
         $rules = [

            'product_id' => 'required',
            'groupe_achats_id' => 'required',
            'unit_price' => 'required|numeric',
            'quantity' => 'required|integer',


         ];

         $request->validate($rules);

         // Récupérer l'achat existant
         if ($achat) {
            // Récupérer le produit associé à l'achat
            // $product = Product::find($achat->product_id);
            $product = $achat->product;
            // dd($product);
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
            $exist_achat = Achat::where('products_id', $request->products_id)
                                ->where('sites_id', $request->sites_id)
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

                'product_id' => $request->product_id,
                'groupe_achats_id' => $request->groupe_achats_id,

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


    public function getData($sites_id=null){

        if (!$sites_id || $sites_id == 'all') {
            $achats = Achat::orderByDesc('created_at')->get();
        }else{
            $achats = Achat::where('sites_id' , $sites_id)->orderByDesc('created_at')->get();
        }

        $data = [];
        foreach ($achats as $key => $achat) {
            $status = $achat->status ?
                        '
                            <span class="dot bg-success d-sm-none"></span>
                            <span class="badge badge-sm badge-dot has-bg bg-success d-none d-sm-inline-flex">Validé</span>
                        ' :
                        '
                            <span class="dot bg-danger d-sm-none"></span>
                            <span class="badge badge-sm badge-dot has-bg bg-danger d-none d-sm-inline-flex">En attente de validation</span>
                        ';

            $route_edit = route('achat.edit' , $achat);
            $route_enabled = route('achat.enabled' , $achat->id);

            $actions = Auth::user()->status == "super_admin" ? 'N/A' :
            (
                $achat->status ? " " : '
                    <ul class="nk-tb-actions gx-1 my-n1">
                        <li class="me-n1">
                            <div class="dropdown">
                                <a href="#" class="dropdown-toggle btn btn-icon btn-trigger" data-bs-toggle="dropdown"><em class="icon ni ni-more-h"></em></a>
                                <div class="dropdown-menu dropdown-menu-end">
                                    <ul class="link-list-opt no-bdr">

                                        <li>
                                            <a href="'.$route_edit.'">
                                                <em class="icon ni ni-edit"></em>
                                                <span>Modifier</span>
                                            </a>
                                        </li>

                                        <li>
                                            <a href="'.$route_enabled.'">
                                                <em class="icon ni ni-activity-round"></em>
                                                <span>
                                                    Validé
                                                </span>
                                            </a>
                                        </li>

                                    </ul>
                                </div>
                            </div>
                        </li>
                    </ul>
                '
            );

            $data[$key] = [

                'id'                => ($key+1),
                'num'               => $achat->numero_achat,
                'name'              => $achat->product->name,
                'unit_price'        => number_format( $achat->unit_price , 0 , '' , ' '),
                'quantity'          => $achat->quantity,
                'total_price'       => number_format( $achat->total_price , 0 , '' , ' '),
                'date'              => $achat->date_achat,
                'by'                => $achat->user->lastname.' '.$achat->user->firstname,
                'status'            => $status,
                'actions'           => $actions

            ];
        }

        return response()->json(['data' => $data ]);

    }

}
