<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Drugstore;
use Illuminate\Support\Facades\Storage;

class DrugstoreProfileController extends Controller
{
    public function show()
    {
        $drugstore = Drugstore::where('user_id', Auth::id())->first();
        $store_id = $drugstore->id ?? null;

        // Get counts for header notifications
        $lowStockCount = \App\Models\Medicine::where('store_id', $store_id)
            ->where('quantity', '<', 20)
            ->count();
        
        $lowStockMedicines = \App\Models\Medicine::where('store_id', $store_id)
            ->where('quantity', '<', 20)
            ->orderBy('quantity', 'asc')
            ->take(5)
            ->get();

        $pendingOrders = \App\Models\Order::where('store_id', $store_id)
            ->where('status', 'pending')
            ->count();

        $recentOrders = \App\Models\Order::where('store_id', $store_id)
            ->where('status', 'pending')
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();

        return view('drugstore.profile.show', compact(
            'drugstore',
            'lowStockCount',
            'lowStockMedicines',
            'pendingOrders',
            'recentOrders'
        ));
    }

    public function update(Request $request)
    {
        $drugstore = Drugstore::where('user_id', Auth::id())->first();
        $user = Auth::user();

        $validatedData = $request->validate([
            'storename' => 'required|string|max:255',
            'licenseno' => 'required|string|max:255',
            'storeaddress' => 'required|string',
            'operatingdays' => 'required|string',
            'bir_number' => 'nullable|string'
        ]);

        // Update the drugstore
        $drugstore->update($validatedData);

        // Update the user's username to match the store name
        $user->update([
            'username' => $validatedData['storename']
        ]);

        return redirect()->route('drugstore.profile')->with('success', 'Profile updated successfully.');
    }
}
