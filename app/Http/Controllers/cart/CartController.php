<?php

namespace App\Http\Controllers\cart;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\Client;
use App\Models\Product;
use App\Models\Sale;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CartController extends Controller
{
    public function index() {
        $carts = Cart::with('product')->get();
        return view('content.carts.cartsIndex', compact('carts'));
    }

    public function store(Request $request) {
        $product = Product::findOrFail($request->product_id);

        $cart = Cart::where('product_id', $product->id)->first();
        if ($cart) {
            $cart->quantity += $request->quantity;
            $cart->save();
        } else {
            Cart::create([
                'product_id' => $product->id,
                'quantity' => $request->quantity,
            ]);
        }

        return redirect()->route('sales.create');
    }

    public function update(Request $request, $id) {
        $cart = Cart::findOrFail($id);
        $cart->quantity = $request->quantity;
        $cart->save();

        return redirect()->route('sales.create');
    }

    public function destroy($id) {
        $cart = Cart::findOrFail($id);
        $cart->delete();
        return redirect()->route('sales.create');
    }

    public function checkout(Request $request)
    {
        $clientId = $request->input('clientId');
        $clientName = $request->input('clientName');
        $phoneNumber = $request->input('phoneNumber');

        if ($clientId == 0) {
            return back()->with('errorMessage', 'Selecione um cliente válido.');
        }
        
        if (!$clientId && $clientName && $phoneNumber) {
            $client = Client::create([
                'clientName' => $clientName,
                'phoneNumber' => $phoneNumber
            ]);
            $clientId = $client->id;
        }

        if (!$clientId) {
            return back()->with('errorMessage', 'Selecione um cliente ou insira um nome e contato para criar um novo cliente.');
        }

        $carts = Cart::with('product')->get();

        try {
            DB::beginTransaction();

            foreach ($carts as $cart) {
                $product = Product::findOrFail($cart->product_id);
                $product->inStock -= $cart->quantity;
                $product->save();

                Sale::create([
                    'clientId' => $clientId,
                    'productId' => $cart->product_id,
                    'totalValue' => $cart->product->saleValue * $cart->quantity,
                    'quantity' => $cart->quantity,
                ]);
            }

            DB::commit();
            
            Cart::truncate();

            return back()->with('successMessage', 'Venda registrada com sucesso!');
        } catch (Exception $e) {
            DB::rollback();
            return back()->with('errorMessage', 'Erro ao registrar venda: ' . $e->getMessage());
        }
    }


    public function clearCart() {
        Cart::truncate();

        return redirect()->route('sales.create')->with('successMessage', 'Carrinho esvaziado.');
    }
}
