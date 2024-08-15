<?php

namespace App\Http\Controllers\products;

use App\Http\Controllers\Controller;
use App\Http\Requests\product\StoreProductRequest;
use App\Models\Product;
use Illuminate\Http\Request;

class productController extends Controller
{
    public function index(Request $request)
    {
        $query = Product::query();

        if ($request->filled('name')) {
            $query->where('productName', 'like', '%' . $request->name . '%');
        }

        if ($request->filled('min_price')) {
            $query->where('saleValue', '>=', $request->min_price);
        }

        if ($request->filled('max_price')) {
            $query->where('saleValue', '<=', $request->max_price);
        }

        if ($request->filled('in_stock')) {
            $query->where('inStock', '>', 0);
        }

        $products = $query->orderBy('created_at', 'desc')->paginate(10);
        return view('content.products.productsIndex', compact('products'));
    }


    public function create ()
    {
        return view("content.products.productsCreate");
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreProductRequest $request) // Modifique o tipo do parâmetro
    {
        $data = $request->only([
            'productName',
            'description',
            'cost',
            'saleValue',
            'inStock',
            'markup'
        ]);

        $data['cost'] = floatval($request->input('cost'));
        $data['saleValue'] = floatval($request->input('saleValue'));
        $data['inStock'] = intval($request->input('inStock'));

        $data['markup'] = (($request->saleValue - $request->cost) / $request->cost) * 100;

        $created = Product::create($data);

        if ($created) {
            return redirect()
                ->route('products.create')
                ->with(['successMessage' => 'Produto registrado com sucesso!']);
        }

        return redirect()
            ->route('products.create')
            ->with(['errorMessage' => 'Não foi possível registrar o produto!']);
    }

    /**
     * Display the specified resource.
     */
    public function show(Product $product)
    {
        if ($product) {
            return view('content.products.productsShow', compact('product'));
        }

        return view('dashboard.home');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Product $product)
    {
        return view('content.products.productsEdit', compact('product'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(StoreProductRequest $request, Product $product)
    {
        $data = $request->only([
            'productName',
            'description',
            'cost',
            'saleValue',
            'inStock',
            'markup'
        ]);

        $data['cost'] = floatval($request->input('cost'));
        $data['saleValue'] = floatval($request->input('saleValue'));
        $data['inStock'] = intval($request->input('inStock'));
        
        $data['markup'] = (($request->saleValue - $request->cost) / $request->cost) * 100;

        $updated = $product->update($data);

        if ($updated) {
            return redirect()->back()->with(['successMessage' => 'Produto atualizado com sucesso!']);
        }
        
        return redirect()->back()->with(['errorMessage' => 'Não foi possível atualizar o produto!']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        $product->delete();
        return redirect()->back()->with('errorMessage', 'Produto deletado com sucesso!');
    }
}
