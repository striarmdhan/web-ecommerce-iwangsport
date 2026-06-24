<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Address;
use Illuminate\Http\Request;

class AddressController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'label' => 'required|string|max:50',
            'recipient' => 'required|string|max:100',
            'phone' => 'required|string|max:20',
            'full_address' => 'required|string|max:500',
            'is_default' => 'nullable|boolean',
        ]);

        $validated['user_id'] = auth()->id();
        $validated['is_default'] = $request->boolean('is_default');

        // If this address is set as default, unset others
        if ($validated['is_default']) {
            auth()->user()->addresses()->update(['is_default' => false]);
        }

        // If user has no addresses yet, make this the default
        if (auth()->user()->addresses()->count() === 0) {
            $validated['is_default'] = true;
        }

        Address::create($validated);

        return back()->with('success', 'Alamat berhasil ditambahkan!');
    }

    public function update(Request $request, Address $address)
    {
        // Ensure the address belongs to the authenticated user
        if ($address->user_id !== auth()->id()) {
            abort(403);
        }

        $validated = $request->validate([
            'label' => 'required|string|max:50',
            'recipient' => 'required|string|max:100',
            'phone' => 'required|string|max:20',
            'full_address' => 'required|string|max:500',
            'is_default' => 'nullable|boolean',
        ]);

        $validated['is_default'] = $request->boolean('is_default');

        if ($validated['is_default']) {
            auth()->user()->addresses()->where('id', '!=', $address->id)->update(['is_default' => false]);
        }

        $address->update($validated);

        return back()->with('success', 'Alamat berhasil diperbarui!');
    }

    public function destroy(Address $address)
    {
        if ($address->user_id !== auth()->id()) {
            abort(403);
        }

        $wasDefault = $address->is_default;
        $address->delete();

        // If deleted address was default, set the first remaining as default
        if ($wasDefault) {
            $firstAddress = auth()->user()->addresses()->first();
            if ($firstAddress) {
                $firstAddress->update(['is_default' => true]);
            }
        }

        return back()->with('success', 'Alamat berhasil dihapus!');
    }

    public function setDefault(Address $address)
    {
        if ($address->user_id !== auth()->id()) {
            abort(403);
        }

        auth()->user()->addresses()->update(['is_default' => false]);
        $address->update(['is_default' => true]);

        return back()->with('success', 'Alamat utama berhasil diubah!');
    }
}
