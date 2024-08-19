<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Vente;
use App\Models\Achat;
use App\Models\Site;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        // if ($request->sites_id) {
        //     dd($request->sites_id);
        // }
        $products = Product::orderByDesc('created_at')->get();
        $sites = Site::where('isActive', true)->get();
        return view('product.index' , compact('products' , 'sites'));
    }

    public function getData($sites_id=null){

        if (!$sites_id || $sites_id == 'all') {
            $products = Product::orderByDesc('created_at')->get();
        }else{
            $products = Product::where('sites_id' , $sites_id)->orderByDesc('created_at')->get();
        }

        $data = [];
        foreach ($products as $key => $product) {
            $status = $product->isActive ?
                        '
                            <span class="dot bg-success d-sm-none"></span>
                            <span class="badge badge-sm badge-dot has-bg bg-success d-none d-sm-inline-flex">Active</span>
                        ' :
                        '
                            <span class="dot bg-danger d-sm-none"></span>
                            <span class="badge badge-sm badge-dot has-bg bg-danger d-none d-sm-inline-flex">Désactivé</span>
                        ';

            $enabled = $product->isActive ? "Désactiver" : "Activer";
            $route_edit = route('product.edit' , $product);
            $route_enabled = route('product.enabled' , $product->id);

            $actions = '
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
                                                '.$enabled.'
                                            </span>
                                        </a>
                                    </li>

                                </ul>
                            </div>
                        </div>
                    </li>
                </ul>
            ';

            $data[$key] = [
                'id'                => ($key+1),
                'name'              => $product->name,
                'price'             => number_format( $product->price , 0 , '' , ' '),
                'quantity'          => $product->quantity,
                'by'                => $product->users->lastname.' '.$product->users->firstname,
                'date'              => $product->created_at,
                'status'            => $status,
                'actions'           => $actions
            ];
        }

        return response()->json(['data' => $data ]);

    }
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $sites = Site::where('isActive', true)->get();
        return view('product.create' , compact('sites'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $products = $request->product;
        $create = 0;

        foreach ($products as $product) {

            if ($product['name'] && $product['price']) {

                $name   = mb_strtoupper($product['name']);
                $price   = mb_strtoupper($product['price']);
                $sites_id   = mb_strtoupper($product['sites_id']);

                $create_product = Product::create([
                    'name'      => strtoupper($name),
                    'price'     => $price,
                    'sites_id'  => $sites_id,
                    'users_id'  => Auth::id(),
                ]);

                if ($create_product) $create = $create + 1;
            }

        }

        if (isset($create_product)) {
            return redirect()->route('product.index')->with(['success' => "Vous venez d'enregistrer ".$create." produit(s)."]);
        }else {
            return redirect()->route('product.index')->with(['error' => "Enregistrement echoué. Veuillez verifier vos informations saisies."]);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Product $product)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Product $product)
    {
        $sites = Site::where('isActive', true)->get();
        return view('product.edit' , compact('product' , 'sites'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Product $product)
    {
        $rules = [ 'name' => 'required|string' , 'price' => 'required|string' , 'sites_id' => 'required' ];

        $request->validate($rules);

        // $product = Product::find($id);

        if($product){
            // Verify if new subcategorie already exists
            $exist_product = Product::where('name', $request->name)->where('sites_id' , $request->sites_id)->first();

            if($exist_product && $exist_product->id != $product->id){
                return redirect()->back()
                                ->with('error', 'Ce produit existe déjà');
            }

            $data['name'] = $request->name;
            $data['price'] = $request->price;
            $data['sites_id'] = $request->sites_id;

            $product->update($data);

            return redirect()->route('product.index')
                            ->with('success', 'Produit modifiée avec succès');
        }else{
            return redirect()->route('product.index')
                            ->with('error', 'Ce produit n\'existe pas');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        //
    }

    public function enabled($id){


        $product = Product::find($id);
        $isActive = $product->isActive  ? 0 : 1;
        $product->isActive = $isActive;
        $product->save();
        $message = $product->isActive ? "Produit activé" : "Produit désactivé";

        return redirect()->back()->with('success', $message);

    }

        public function getQuantity($id)
    {
        $quantity = Product::where('product_id', $id)->sum('quantity');
        return response()->json(['quantity' => $quantity]);
    }
}
