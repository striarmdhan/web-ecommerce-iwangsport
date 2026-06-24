<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\CartItem;
use App\Models\ProductVariant;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function index()
    {
        $cart = auth()->user()->getCartOrCreate();
        $cart->load('items.productVariant.product');

        return view('customer.cart.index', compact('cart'));
    }

    public function add(Request $request)
    {
        $validated = $request->validate([
            'product_variant_id' => 'required|exists:product_variants,id',
            'quantity' => 'required|integer|min:1',
        ]);

        $variant = ProductVariant::findOrFail($validated['product_variant_id']);

        if ($variant->stock < $validated['quantity']) {
            return back()->with('error', 'Stok tidak mencukupi.');
        }

        $cart = auth()->user()->getCartOrCreate();

        // Check if item already exists
        $existingItem = $cart->items()
            ->where('product_variant_id', $validated['product_variant_id'])
            ->first();

        if ($existingItem) {
            $newQty = $existingItem->quantity + $validated['quantity'];
            if ($newQty > $variant->stock) {
                return back()->with('error', 'Stok tidak mencukupi.');
            }
            $existingItem->update(['quantity' => $newQty]);
        } else {
            $cart->items()->create([
                'product_variant_id' => $validated['product_variant_id'],
                'quantity' => $validated['quantity'],
            ]);
        }

        return back()->with('success', 'Produk berhasil ditambahkan ke keranjang.');
    }

    public function update(Request $request, CartItem $item)
    {
        $validated = $request->validate([
            'quantity' => 'required|integer|min:1',
        ]);

        if ($validated['quantity'] > $item->productVariant->stock) {
            return back()->with('error', 'Stok tidak mencukupi.');
        }

        $item->update(['quantity' => $validated['quantity']]);

        return back()->with('success', 'Keranjang berhasil diupdate.');
    }

    public function remove(CartItem $item)
    {
        $item->delete();
        return back()->with('success', 'Item berhasil dihapus dari keranjang.');
    }
}
