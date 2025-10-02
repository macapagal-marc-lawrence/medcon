<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DrugstoreOrderController extends Controller
{
    public function complete($id)
    {
        try {
            DB::beginTransaction();
            $order = Order::findOrFail($id);
            
            if ($order->status !== 'approved') {
                throw new \Exception('Only approved orders can be marked as completed.');
            }
            
            $order->status = 'completed';
            $order->completed_at = now();
            $order->save();
            
            DB::commit();
            return response()->json(['success' => true, 'message' => 'Order has been marked as completed successfully.']);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['success' => false, 'message' => $e->getMessage()], 422);
        }
    }
    public function approve($id)
    {
        try {
            DB::beginTransaction();
            
            $order = Order::findOrFail($id);
            
            // Check if order is already processed
            if ($order->status !== 'pending') {
                throw new \Exception('Order has already been processed.');
            }
            
            // Log before state
            \Log::info('Before approving order:', [
                'order_id' => $order->id,
                'status' => $order->status,
                'store_id' => $order->store_id
            ]);
            
            // Load order items with medicines
            $order->load('items.medicine');

            // Check if all medicines have enough stock
            foreach ($order->items as $item) {
                if ($item->medicine->quantity < $item->quantity) {
                    throw new \Exception("Not enough stock for {$item->medicine->medicine_name}");
                }
            }

            // Deduct quantities from medicines when approving
            foreach ($order->items as $item) {
                $medicine = $item->medicine;
                $medicine->quantity -= $item->quantity;
                $medicine->save();
            }

            // Update order status
            \Illuminate\Support\Facades\DB::table('orders')
                ->where('id', $order->id)
                ->update([
                    'status' => 'approved',
                    'approved_at' => now()
                ]);
                
            // Verify the update with raw SQL
            $verifyStatus = \Illuminate\Support\Facades\DB::select(
                'SELECT id, status, approved_at FROM orders WHERE id = ?',
                [$order->id]
            );
            
            \Log::info('Direct database verification:', [
                'order' => $verifyStatus[0] ?? null
            ]);
            
            // Refresh the model
            $order->refresh();
            
            \Log::info('After approving order (model refresh):', [
                'order_id' => $order->id,
                'status' => $order->status,
                'approved_at' => $order->approved_at
            ]);
            
            DB::commit();
            
            return response()->json([
                'success' => true,
                'message' => 'Order has been approved successfully.'
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 422);
        }
    }

    public function reject($id)
    {
        try {
            DB::beginTransaction();
            
            $order = Order::findOrFail($id);
            
            // Check if order is already processed
            if ($order->status !== 'pending') {
                throw new \Exception('Order has already been processed.');
            }
            
            // Log before state
            \Log::info('Before rejecting order:', [
                'order_id' => $order->id,
                'status' => $order->status,
                'store_id' => $order->store_id
            ]);
            
            // Reject the order using model method
            $order->reject();
            
            // Double-check the status
            $freshOrder = Order::find($order->id);
            \Log::info('After rejecting order (fresh query):', [
                'order_id' => $freshOrder->id,
                'status' => $freshOrder->status,
                'rejected_at' => $freshOrder->rejected_at
            ]);
            
            // Return items to inventory
            foreach ($order->items as $item) {
                $medicine = $item->medicine;
                $medicine->quantity += $item->quantity;
                $medicine->save();
            }
            
            DB::commit();
            
            return response()->json([
                'success' => true,
                'message' => 'Order has been rejected successfully.'
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 422);
        }
    }



}
