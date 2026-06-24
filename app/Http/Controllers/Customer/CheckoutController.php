<?php

namespace App\Http\Controllers\Customer;

use App\Enums\OrderStatus;
use App\Enums\PaymentMethod;
use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Payment;
use App\Models\StoreSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CheckoutController extends Controller
{
    public function index()
    {
        $cart = auth()->user()->getCartOrCreate();
        $cart->load('items.productVariant.product');

        if ($cart->items->isEmpty()) {
            return redirect()->route('cart.index')->with('error', 'Keranjang kosong.');
        }

        $addresses = auth()->user()->addresses;
        $storeSettings = StoreSetting::get();

        return view('customer.checkout.index', compact('cart', 'addresses', 'storeSettings'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'address_id' => 'required|exists:addresses,id',
            'payment_method' => 'required|in:qris,transfer',
            'notes' => 'nullable|string|max:500',
        ]);

        $cart = auth()->user()->getCartOrCreate();
        $cart->load('items.productVariant.product');

        if ($cart->items->isEmpty()) {
            return redirect()->route('cart.index')->with('error', 'Keranjang kosong.');
        }

        $address = auth()->user()->addresses()->findOrFail($validated['address_id']);

        DB::beginTransaction();

        try {
            $subtotal = $cart->items->sum(function ($item) {
                return $item->productVariant->product->price * $item->quantity;
            });

            $shippingCost = 0; // Akan ditentukan admin
            $total = $subtotal + $shippingCost;

            $order = Order::create([
                'user_id' => auth()->id(),
                'invoice_number' => Order::generateInvoiceNumber(),
                'status' => OrderStatus::Pending,
                'subtotal' => $subtotal,
                'shipping_cost' => $shippingCost,
                'total' => $total,
                'payment_method' => $validated['payment_method'],
                'shipping_address' => $address->full_address,
                'recipient_name' => $address->recipient,
                'recipient_phone' => $address->phone,
                'shipping_note' => $validated['notes'] ?? null,
            ]);

            foreach ($cart->items as $item) {
                $order->items()->create([
                    'product_variant_id' => $item->product_variant_id,
                    'product_name' => $item->productVariant->product->name,
                    'variant_info' => $item->productVariant->variant_label,
                    'price' => $item->productVariant->product->price,
                    'quantity' => $item->quantity,
                    'subtotal' => $item->productVariant->product->price * $item->quantity,
                ]);
            }

            $order->payment()->create([
                'method' => PaymentMethod::from($validated['payment_method']),
                'status' => 'pending',
            ]);

            // Clear cart
            $cart->items()->delete();

            DB::commit();

            return redirect()->route('orders.show', $order->id)
                ->with('success', 'Pesanan berhasil dibuat! Silakan lakukan pembayaran.');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Terjadi kesalahan. Silakan coba lagi.');
        }
    }
}
