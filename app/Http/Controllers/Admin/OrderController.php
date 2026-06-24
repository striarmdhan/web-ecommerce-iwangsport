<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index(Request $request)
    {
        $query = Order::with(['user', 'items']);

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $orders = $query->latest()->paginate(15);

        return view('admin.orders.index', compact('orders'));
    }

    public function show(Order $order)
    {
        $order->load(['user', 'items.productVariant.product', 'payment']);

        return view('admin.orders.show', compact('order'));
    }

    public function verify(Request $request, Order $order)
    {
        $validated = $request->validate([
            'action' => 'required|in:approve,reject',
        ]);

        if ($validated['action'] === 'approve') {
            $order->payment->update([
                'status' => 'verified',
                'verified_at' => now(),
                'verified_by' => auth()->id(),
            ]);

            $order->update(['status' => 'processing']);

            // Reduce stock
            foreach ($order->items as $item) {
                $item->productVariant->decrement('stock', $item->quantity);
            }

            return back()->with('success', 'Pembayaran berhasil diverifikasi.');
        }

        $order->payment->update([
            'status' => 'rejected',
            'verified_at' => now(),
            'verified_by' => auth()->id(),
        ]);

        $order->update(['status' => 'rejected']);

        return back()->with('success', 'Pembayaran ditolak.');
    }

    public function updateShipping(Request $request, Order $order)
    {
        $validated = $request->validate([
            'shipping_cost' => 'required|numeric|min:0',
        ]);

        $order->update([
            'shipping_cost' => $validated['shipping_cost'],
            'total' => $order->subtotal + $validated['shipping_cost'],
        ]);

        // If order was pending (waiting for shipping), confirm it so customer can pay
        if ($order->status->value === 'pending') {
            $order->update(['status' => 'shipping_confirmed']);
        }

        return back()->with('success', 'Ongkir berhasil diupdate.');
    }

    public function ship(Request $request, Order $order)
    {
        $validated = $request->validate([
            'tracking_number' => 'nullable|string|max:255',
        ]);

        $order->update([
            'status' => 'shipped',
            'tracking_number' => $validated['tracking_number'] ?? null,
        ]);

        return back()->with('success', 'Pesanan berhasil dikirim.');
    }

    public function complete(Order $order)
    {
        $order->update(['status' => 'completed']);
        return back()->with('success', 'Pesanan selesai.');
    }
}
