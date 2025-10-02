<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cart;
use App\Models\Customer;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    private function getCustomerId()
    {
        return Customer::where('user_id', Auth::id())->first()->id;
    }

    public function addToCart(Request $request)
    {
        try {
            $customer_id = $this->getCustomerId();
            $medicine_id = $request->medicine_id;
            $store_id = $request->store_id;

            $existingCart = Cart::where('customer_id', $customer_id)
                               ->where('medicine_id', $medicine_id)
                               ->whereNull('order_id')
                               ->first();

            if ($existingCart) {
                $existingCart->quantity++;
                $existingCart->save();
            } else {
                Cart::create([
                    'customer_id' => $customer_id,
                    'store_id' => $store_id,
                    'medicine_id' => $medicine_id,
                    'quantity' => 1
                ]);
            }

            if ($request->ajax()) {
                return response()->json(['success' => true, 'message' => 'Medicine added to cart!']);
            }
            return redirect()->route('home')->with('success', 'Medicine added to cart!');
        } catch (\Exception $e) {
            \Log::error('Error adding to cart: ' . $e->getMessage());
            return redirect()->route('home')->with('error', 'Error adding medicine to cart');
        }
    }

    public function removeFromCart(Request $request)
    {
        try {
            $customer_id = $this->getCustomerId();
            Cart::where('customer_id', $customer_id)
                ->where('medicine_id', $request->medicine_id)
                ->whereNull('order_id')
                ->delete();

            return redirect()->back()->with('success', 'Medicine removed from cart!');
        } catch (\Exception $e) {
            \Log::error('Error removing from cart: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Error removing medicine from cart');
        }
    }

    public function updateCart(Request $request)
    {
        try {
            $request->validate([
                'medicine_id' => 'required',
                'quantity' => 'required|integer|min:1'
            ]);

            $customer_id = $this->getCustomerId();
            $cart = Cart::where('customer_id', $customer_id)
                       ->where('medicine_id', $request->medicine_id)
                       ->whereNull('order_id')
                       ->first();

            if (!$cart) {
                return redirect()->back()->with('error', 'Medicine not found in cart');
            }

            $cart->quantity = $request->quantity;
            $cart->save();

            return redirect()->back()->with('success', 'Cart updated successfully');
        } catch (\Exception $e) {
            \Log::error('Error updating cart: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Error updating cart');
        }
    }
}