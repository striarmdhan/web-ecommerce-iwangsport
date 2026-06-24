<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Favourite;
use App\Models\Product;
use Illuminate\Http\Request;

class FavouriteController extends Controller
{
    public function index()
    {
        $favourites = auth()->user()
            ->favourites()
            ->with('product.category')
            ->latest()
            ->get();

        return view('customer.favourites.index', compact('favourites'));
    }

    public function toggle(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
        ]);

        $user = auth()->user();

        $favourite = Favourite::where('user_id', $user->id)
            ->where('product_id', $request->product_id)
            ->first();

        if ($favourite) {
            $favourite->delete();
            $status = 'removed';
        } else {
            Favourite::create([
                'user_id' => $user->id,
                'product_id' => $request->product_id,
            ]);
            $status = 'added';
        }

        if ($request->ajax()) {
            $count = $user->favourites()->count();
            return response()->json(['status' => $status, 'count' => $count]);
        }

        return back()->with('success', $status === 'added' ? 'Produk ditambahkan ke favourite.' : 'Produk dihapus dari favourite.');
    }
}
