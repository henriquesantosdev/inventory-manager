<?php

namespace App\Http\Controllers\sales;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\Client;
use App\Models\Product;
use App\Models\Sale;
use Illuminate\Http\Request;

class SaleController extends Controller
{
    public function index(Request $request)
    {
        $query = Sale::with(['client', 'product']);

        // Aplicar filtros
        if ($request->filled('client')) {
            $query->whereHas('client', function($q) use ($request) {
                $q->where('clientName', 'like', '%' . $request->client . '%');
            });
        }

        if ($request->filled('product')) {
            $query->whereHas('product', function($q) use ($request) {
                $q->where('productName', 'like', '%' . $request->product . '%');
            });
        }

        if ($request->filled('date')) {
            $query->whereDate('created_at', $request->date);
        }

        $sales = $query->orderBy('created_at', 'desc')->paginate(10);
        return view('content.sales.salesIndex', compact('sales'));
    }

    public function create()
    {
        $clients = Client::orderBy('clientName', 'asc')->get();
        $carts = Cart::with('product')->get();
        $products = Product::orderBy('created_at', 'desc')->paginate(10);
        return view('content.sales.salesCreate', compact('clients', 'products', 'carts'));
    }

    public function destroy($id)
    {
        $sale = Sale::findOrFail($id);
        $sale->delete();
        return redirect()->route('sales.index')->with('errorMessage', 'Venda deletada com sucesso!');
    }

}
