<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Vente;
use App\Models\Product;
use App\Models\Achat;
use App\Models\Site;
use App\Models\GroupeVente;
use Illuminate\Support\Facades\Auth;

class VenteController extends Controller
{


     public function index()
    {
        $sites = Site::where('isActive', true)->get();

        return view('ventes.index', compact('sites'));
    }


    public function create()
    {
        $user = Auth::user();

        $siteId = $user->sites_id;

        // Filtrer les produits en fonction du site_id
        $products = Product::where('sites_id', $siteId)->where("quantity" , ">" , "0")->get();
        //  dd($siteId);
        $sites = Site::where('isActive', true)->get();
        $siteId = $user->site_id;
        // $groupes = GroupeAchat::orderByDesc('created_at')->get();
        // Récupérer les groupes d'achat créés par l'utilisateur authentifié
        $groupes = GroupeVente::where('users_id', Auth::id())
        ->orderByDesc('created_at')
        ->get();

        return view('ventes.create', compact('sites','products' , 'groupes'));
    }


    public function store(Request $request)
    {

        $ventes = $request->vente;
        $create = 0;

        foreach ($ventes as $vente) {

            // Préparation des données
            $site_id = $vente['site_id'];
            $product_id = $vente['product_id'];
            $quantity = (int)$vente['quantity'];
            $price = (float)$vente['unit_price'];
            $groupe_ventes_id = $vente['groupe_ventes_id'];
            // $total_price = $price * $quantity;
            $total_price = $vente['total_vente'];

            if ($site_id && $product_id && $quantity && $price && $groupe_ventes_id && $total_price) {

                // Récupérer le produit
                $produit = Product::where('id', $product_id)->first();

                // Vérifier la quantité disponible
                if ($produit) {

                    $availableStock = $produit->quantity ?? 0;

                    if ($quantity <= $availableStock) {

                        // Génération du num de vente
                        $numeroVente = generateUniqueNumber('VENTE-', Vente::class, 'numero_vente');

                        // Création d'une nouvelle vente
                        $create_vente = Vente::create([
                            'products_id'       => $product_id,
                            // 'achats_id'         => Achat::where('products_id', $product_id)->first()->id,
                            'sites_id'          => $site_id,
                            'quantity'          => $quantity,
                            'price'             => $price,
                            'groupe_ventes_id'  => $groupe_ventes_id,
                            'total_price'       => $total_price,
                            'vente_date'        => now(),
                            'numero_vente'      => $numeroVente,
                            'users_id'          => Auth::id(),
                        ]);

                        if ($create_vente) {
                            // Mettre à jour la quantité disponible dans la table produit
                            $produit->quantity -= $quantity;
                            $produit->save();
                            $create++;
                        }
                    }
                }

            }

        }

        if ($create > 0) {
            return redirect()->route('ventes.index')->with(['success' => "Vous venez d'enregistrer ".$create." vente(s)."]);
        } else {
            return redirect()->route('ventes.index')->with(['error' => "Enregistrement échoué. Veuillez vérifier vos informations saisies."]);
        }
    }


    public function destroy($id)
    {
        // Trouver la vente par ID
        $vente = Vente::find($id);

        if ($vente) {
            // Trouver le produit correspondant à la vente
            $product = Product::find($vente->products_id);

            if ($product) {
                // Ajouter la quantité de la vente à la quantité du produit
                $product->quantity += $vente->quantity;
                $product->save();
            }

            // Supprimer la vente
            $vente->delete();

            return redirect()->route('ventes.index')->with('success', 'Vente supprimée avec succès et quantité de produit mise à jour.');
        } else {
            return redirect()->route('ventes.index')->with('error', 'Vente non trouvée.');
        }
    }

    /**
     * Toggle the activation status of the specified resource.
     */
    public function enabled($id)
    {
        // Trouver la vente par son ID
        $vente = Vente::find($id);

        // Vérifier si la vente existe
        if (!$vente) {
            return redirect()->route('ventes.index')->with('error', 'Vente non trouvée.');
        }

        // Déterminer le nouveau statut en fonction de l'état actuel
        $vente->status = ($vente->status === 'non validée') ? 'validée' : 'non validée';

        // Sauvegarder les changements dans la base de données
        $vente->save();

        // Déterminer le message en fonction du nouveau statut
        $message = $vente->status === 'validée' ? "Vente validée" : "Vente non validée";

        // Rediriger avec le message de succès
        return redirect()->back()->with('success', $message);
    }


    public function edit(Vente $vente)
    {
        $user = Auth::user();



        $siteId = $user->sites_id;
        $sites = $user->sites_id;

        // Filtrer les produits en fonction du site_id
        $products = Product::where('sites_id', $siteId)->get();
        //  dd($siteId);
        $sites = Site::where('isActive', true)->get();
        return view('ventes.edit', compact('vente', 'sites', 'products'));
    }

    /**
     * Update the specified resource in storage.
     */

    public function updateCustom(Request $request, Vente $vente)
    {
    // dd($request);
    $rules = [
        'products_id' => 'required|exists:products,id',
        'site_id' => 'required|exists:sites,id',
        'quantity' => 'required|integer|min:1',
        'price' => 'required|numeric|min:0',
    ];

    $request->validate($rules);

    // Récupérer les informations du produit
    $product = Product::find($request->products_id);

    if (!$product) {
        return response()->json(['error' => 'Produit non trouvé'], 404);
    }

    // Quantité actuelle de la vente
    $currentVenteQuantity = $vente->quantity;
    // Nouvelle quantité demandée
    $newVenteQuantity = $request->quantity;
    // Quantité disponible dans la table products
    $availableQuantity = $product->quantity;
    // Calcul de la nouvelle quantité disponible après mise à jour
    $updatedAvailableQuantity = $availableQuantity - $newVenteQuantity + $currentVenteQuantity;

    // Vérification supplémentaire
    if ($updatedAvailableQuantity < 0) {
        return redirect()->route('ventes.index')->with(['error' => 'Quantité insuffisante. Quantité disponible après mise à jour: ' . $updatedAvailableQuantity]);
    }
    // Calculer le prix total
    $total_price = $request->price * $newVenteQuantity;

    // Mettre à jour les informations de la vente
    if ($vente) {
        // Vérifier si une autre vente avec les mêmes critères existe déjà
        $exist_vente = Vente::where('products_id', $request->products_id)
                            ->where('sites_id', $request->site_id)
                            ->where('price', $request->price)
                            ->where('quantity', $newVenteQuantity)
                            ->first();

        if ($exist_vente && $exist_vente->id != $vente->id) {
            return redirect()->route('ventes.index')->with(['error' => "Cette vente avec les mêmes détails existe déjà"]);
        }

        $data = [
            'products_id' => $request->products_id,
            'sites_id' => $request->site_id,
            'quantity' => $newVenteQuantity,
            'price' => $request->price,
            'total_price' => $total_price
        ];

        $vente->update($data);

            // Mettre à jour la quantité du produit
        $product->quantity = $availableQuantity + $currentVenteQuantity - $newVenteQuantity;
        $product->save();

        return redirect()->route('ventes.index')->with(['success' => "Vente modifiée avec succès"]);
    } else {
        return redirect()->route('ventes.index')->with(['error' => "Cette vente n\'existe pas"]);
    }
    }

    public function getData($sites_id=null){

        if (!$sites_id || $sites_id == 'all') {
            $ventes = Vente::orderByDesc('created_at')->get();
        }else{
            $ventes = Vente::where('sites_id' , $sites_id)->orderByDesc('created_at')->get();
        }

        $data = [];

        foreach ($ventes as $key => $vente) {

            $status = $vente->status == "validée" ?
                        '
                            <span class="dot bg-success d-sm-none"></span>
                            <span class="badge badge-sm badge-dot has-bg bg-success d-none d-sm-inline-flex">Validé</span>
                        ' :
                        '
                            <span class="dot bg-danger d-sm-none"></span>
                            <span class="badge badge-sm badge-dot has-bg bg-danger d-none d-sm-inline-flex">En attente de validation</span>
                        ';

            $route_edit = route('ventes.edit' , $vente);
            $route_enabled = route('ventes.enabled' , $vente->id);


            $actions = Auth::user()->status == "super_admin" ? 'N/A' :
            (
                $vente->status == "validée" ? " " : '
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
                'num'               => $vente->numero_vente,
                'name'              => $vente->product->name,
                'price'             => number_format( $vente->price , 0 , '' , ' '),
                'quantity'          => $vente->quantity,
                'total_price'       => number_format( $vente->total_price , 0 , '' , ' '),
                'date'              => $vente->date_vente,
                'by'                => $vente->user->lastname.' '.$vente->user->firstname,
                'status'            => $status,
                'actions'           => $actions

            ];
        }

        return response()->json(['data' => $data ]);

    }

}
