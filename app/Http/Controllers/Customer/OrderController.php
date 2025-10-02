<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Medicine;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    public function index()
    {
        $customer = auth()->user()->customer;
        
        // Get recent order notifications
        $notifications = \App\Models\Order::where('customer_id', $customer->id)
            ->whereIn('status', ['approved', 'rejected'])
            ->orderBy('updated_at', 'desc')
            ->take(5)
            ->get();
            
        // Count unread notifications
        $unreadNotifications = $notifications->count();
        $orders = auth()->user()->orders()->with(['items.medicine'])->latest()->paginate(10);
        return view('customer.orders.index', compact('orders'));
    }

    public function getOrderHistory()
    {
        return auth()->user()->orders()
            ->with(['items.medicine', 'store'])
            ->latest()
            ->paginate(10); // Show 10 orders per page
    }

    public function store(Request $request)
    {
        try {
            DB::beginTransaction();

            // Log incoming request data
            \Log::info('Orders creation request:', $request->all());

            // Get the customer ID from the authenticated user
            $customerId = auth()->user()->customer->id ?? auth()->id();

            $createdOrders = [];

            // Validate request data
            if (!$request->has('orders') || !is_array($request->orders)) {
                throw new \Exception('Invalid order data format');
            }

            // Validate pickup date
            if (!$request->has('pickup_date')) {
                throw new \Exception('Pickup date is required');
            }

            // Validate pickup date is not in the past
            $pickupTimestamp = strtotime($request->pickup_date);
            if ($pickupTimestamp === false) {
                throw new \Exception('Invalid pickup date format');
            }
            if ($pickupTimestamp < strtotime('today')) {
                throw new \Exception('Pickup date cannot be in the past');
            }

            // Process each order (one per store)
            foreach ($request->orders as $orderData) {
                // Validate required order data
                if (!isset($orderData['store_id'])) {
                    throw new \Exception('Store ID is required for each order');
                }
                if (!isset($orderData['items']) || !is_array($orderData['items'])) {
                    throw new \Exception('Items are required for each order');
                }
                try {
                    // Calculate total amount from items
                    $totalAmount = collect($orderData['items'])->sum(function($item) {
                        return $item['medicine']['medicine_price'] * $item['quantity'];
                    });

                    // Format pickup date
                    $pickupDate = date('Y-m-d H:i:s', strtotime($request->pickup_date));
                    $pickupDeadline = date('Y-m-d 23:59:59', strtotime($request->pickup_date));

                    // Create the order
                    $order = Order::create([
                        'customer_id' => $customerId,
                        'store_id' => $orderData['store_id'],
                        'total_amount' => $totalAmount,
                        'discounted_amount' => 0,
                        'status' => 'pending',
                        'payment_mode' => 'walk-in',
                        'scheduled_pickup_date' => $pickupDate,
                        'pickup_deadline' => $pickupDeadline
                    ]);

                    \Log::info('Order created:', [
                        'order_id' => $order->id,
                        'store_name' => $orderData['store_name']
                    ]);

                    // Create order items
                    foreach ($orderData['items'] as $item) {
                        try {
                            $orderItem = OrderItem::create([
                                'order_id' => $order->id,
                                'medicine_id' => $item['medicine']['id'],
                                'quantity' => $item['quantity'],
                                'price' => $item['medicine']['medicine_price'],
                                'total' => $item['medicine']['medicine_price'] * $item['quantity']
                            ]);

                            \Log::info('Order item created:', ['item_id' => $orderItem->id]);

                            // Just verify medicine exists
                            $medicine = Medicine::find($item['medicine']['id']);
                            if (!$medicine) {
                                throw new \Exception('Medicine not found');
                            }

                            \Log::info('Order item created for medicine:', [
                                'medicine_id' => $medicine->id,
                                'quantity' => $item['quantity']
                            ]);
                        } catch (\Exception $e) {
                            \Log::error('Error creating order item:', [
                                'error' => $e->getMessage(),
                                'item' => $item
                            ]);
                            throw $e;
                        }
                    }

                    $createdOrders[] = [
                        'id' => $order->id,
                        'store_id' => $orderData['store_id'],
                        'store_name' => $orderData['store_name'],
                        'total_amount' => $orderData['total_amount']
                    ];
                } catch (\Exception $e) {
                    \Log::error('Error processing order for store:', [
                        'store_id' => $orderData['store_id'],
                        'error' => $e->getMessage()
                    ]);
                    throw $e;
                }
            }

            // Delete cart items that have been ordered
            foreach ($createdOrders as $createdOrder) {
                foreach ($request->orders as $orderData) {
                    if ($orderData['store_id'] == $createdOrder['store_id']) {
                        // Get all medicine IDs from this order
                        $medicineIds = collect($orderData['items'])->pluck('medicine.id')->toArray();
                        
                        // Delete the cart items
                        DB::table('cart')
                            ->where('customer_id', $customerId)
                            ->where('store_id', $createdOrder['store_id'])
                            ->whereIn('medicine_id', $medicineIds)
                            ->delete();
                    }
                }
            }

            // Clear the session cart
            session()->forget('cart');

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Orders created successfully',
                'orders' => $createdOrders
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            \Log::error('Orders creation error:', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            
            $errorMessage = app()->environment('local') 
                ? 'Error creating orders: ' . $e->getMessage()
                : 'Error creating orders. Please try again.';
            
            return response()->json([
                'success' => false,
                'message' => $errorMessage
            ], 500);
        }
    }

    public function pending()
    {
        $orders = auth()->user()->orders()->where('status', 'pending')->latest()->paginate(10);
        return view('customer.orders.pending', compact('orders'));
    }

    public function processing()
    {
        $orders = auth()->user()->orders()->where('status', 'processing')->latest()->paginate(10);
        return view('customer.orders.processing', compact('orders'));
    }

    public function completed()
    {
        $orders = auth()->user()->orders()->where('status', 'completed')->latest()->paginate(10);
        return view('customer.orders.completed', compact('orders'));
    }

    public function cancelled()
    {
        $orders = auth()->user()->orders()->where('status', 'cancelled')->latest()->paginate(10);
        return view('customer.orders.cancelled', compact('orders'));
    }
}