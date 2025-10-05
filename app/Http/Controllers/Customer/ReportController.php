<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Order;
use App\Models\Medicine;
use App\Models\Customer;

class ReportController extends Controller
{
    /**
     * Display sales reports
     */
    public function sales()
    {
        $customer = Auth::user()->customer;
        
        if (!$customer) {
            return redirect()->route('landing')->withErrors(['error' => 'Customer profile not found.']);
        }

        // Get customer's orders
        $orders = Order::where('customer_id', $customer->id)
            ->with(['items.medicine', 'store'])
            ->orderBy('created_at', 'desc')
            ->get();

        // Calculate statistics
        $totalOrders = $orders->count();
        $totalSpent = $orders->where('status', 'completed')->sum('total_amount');
        $pendingOrders = $orders->where('status', 'pending')->count();
        $completedOrders = $orders->where('status', 'completed')->count();

        return view('customer.reports.sales', compact(
            'orders',
            'totalOrders',
            'totalSpent',
            'pendingOrders',
            'completedOrders'
        ));
    }

    /**
     * Display inventory reports (for drugstore users)
     */
    public function inventory()
    {
        // This would typically be for drugstore users
        // For customers, redirect to appropriate page
        return redirect()->route('landing')->with('info', 'Inventory reports are available for drugstore accounts.');
    }

    /**
     * Display customer reports (for admin users)
     */
    public function customers()
    {
        // This would typically be for admin users
        // For customers, redirect to appropriate page
        return redirect()->route('landing')->with('info', 'Customer reports are available for admin accounts.');
    }
}
