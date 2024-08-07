<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Vente;
use App\Models\Achat;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $products = Product::orderByDesc('created_at')->get();
        return view('product.index' , compact('products'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('product.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $products = $request->product;
        $create = 0;

        foreach ($products as $product) {

            $name   = mb_strtoupper($product['name']);
            $price   = mb_strtoupper($product['price']);

            $create_product = Product::create([
                'name'      => strtoupper($name),
                'price'     => $price,
                'users_id'  => Auth::id(),
            ]);

            if ($create_product) $create = $create + 1;

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
        return view('product.edit' , compact('product'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Product $product)
    {
        $rules = [ 'name' => 'required|string' , 'price' => 'required|string' ];

        $request->validate($rules);

        // $product = Product::find($id);

        if($product){
            // Verify if new subcategorie already exists
            $exist_product = Product::where('name', $request->name)->first();

            if($exist_product && $exist_product->id != $product->id){
                return redirect()->back()
                                ->with('error', 'Ce produit existe déjà');
            }

            $data['name'] = $request->name;
            $data['price'] = $request->price;

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
        $quantity = Produit::where('product_id', $id)->sum('quantity');
        return response()->json(['quantity' => $quantity]);
    }
}
