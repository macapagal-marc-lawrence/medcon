<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Order;
use App\Models\Drugstore;
use App\Models\Cart;

class CustomerController extends Controller
{
    public function index()
    {
        $customer = Auth::user()->customer;
        
        // Get recent order notifications
        $notifications = Order::where('customer_id', $customer->id)
            ->whereIn('status', ['approved', 'rejected'])
            ->orderBy('updated_at', 'desc')
            ->take(5)
            ->get();

        // Get available drugstores with non-expired medicines
        $drugstores = Drugstore::with(['medicines' => function($query) {
            $query->where('quantity', '>', 0)
                  ->where('expiration_date', '>', now());  // Only show medicines that haven't expired
        }])->get();

        // Get cart items
        $cartItems = Cart::where('customer_id', $customer->id)
            ->whereNull('order_id')
            ->with(['medicine', 'store'])
            ->get()
            ->map(function($item) {
                return [
                    'medicine' => $item->medicine,
                    'store' => $item->store,
                    'quantity' => $item->quantity
                ];
            });

        return view('customer.index', compact('notifications', 'drugstores', 'cartItems'));
    }
}
