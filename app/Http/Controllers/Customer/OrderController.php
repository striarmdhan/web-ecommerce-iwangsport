<?php

namespace App\Http\Controllers\Customer;

use App\Enums\PaymentMethod;
use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\StoreSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class OrderController extends Controller
{
    public function index()
    {
        $orders = auth()->user()->orders()
            ->with(['items.productVariant.product'])
            ->latest()
            ->paginate(10);

        return view('customer.orders.index', compact('orders'));
    }

    public function show(Order $order)
    {
        $this->authorize('view', $order);

        $order->load(['items.productVariant.product', 'payment']);
        $storeSettings = StoreSetting::get();

        return view('customer.orders.show', compact('order', 'storeSettings'));
    }

    public function uploadPayment(Request $request, Order $order)
    {
        $this->authorize('update', $order);

        $validated = $request->validate([
            'payment_proof' => 'required|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        // Only allow upload if shipping confirmed or rejected (re-upload)
        if (!in_array($order->status->value, ['shipping_confirmed', 'rejected'])) {
            return back()->with('error', 'Upload bukti pembayaran hanya bisa dilakukan setelah ongkir dikonfirmasi.');
        }

        if ($request->hasFile('payment_proof')) {
            // Delete old proof if exists
            if ($order->payment->proof_path) {
                Storage::disk('public')->delete($order->payment->proof_path);
            }

            $path = $request->file('payment_proof')->store('payment_proofs', 'public');
            
            $order->payment->update([
                'proof_path' => $path,
                'status' => 'pending',
            ]);

            $order->update(['status' => 'waiting_verification']);

            return back()->with('success', 'Bukti pembayaran berhasil diupload. Menunggu verifikasi admin.');
        }

        return back()->with('error', 'Gagal mengupload bukti pembayaran.');
    }

    public function changePaymentMethod(Request $request, Order $order)
    {
        $this->authorize('update', $order);

        // Only allow changing if shipping has been confirmed and no proof uploaded
        if ($order->status->value !== 'shipping_confirmed') {
            return back()->with('error', 'Metode pembayaran hanya dapat diubah setelah ongkir dikonfirmasi.');
        }

        if ($order->payment->proof_path) {
            return back()->with('error', 'Metode pembayaran tidak dapat diubah karena bukti pembayaran sudah diupload.');
        }

        $validated = $request->validate([
            'payment_method' => 'required|in:qris,transfer',
        ]);

        $order->payment->update([
            'method' => PaymentMethod::from($validated['payment_method']),
        ]);

        $order->update([
            'payment_method' => $validated['payment_method'],
        ]);

        return back()->with('success', 'Metode pembayaran berhasil diubah!');
    }
}
