<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Medicine;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Models\PrescriptionSubmission;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Models\Drugstore;
use App\Models\Order;



class DrugstoreController extends Controller
{

public function index()
{
    DB::statement('SET SESSION query_cache_type = OFF');

    // Figure out the current store id for this logged-in drugstore user
    $drugstore = Drugstore::where('user_id', Auth::id())->first();
    $storeId   = $drugstore?->id; // <-- this must not be null

    // If no drugstore row is linked to this user, you will never see data
    // Fail early so it's obvious instead of rendering "empty"
    if (!$storeId) {
        // You can change this to a redirect with a flash message if you want
        abort(403, 'No drugstore record linked to this account (users.id=' . Auth::id() . ').');
    }

    // ---------- Existing dashboard data ----------
    $totalMedicines    = Medicine::where('store_id', $storeId)->count();
    $lowStockMedicines = Medicine::where('store_id', $storeId)
                            ->where('quantity', '<', 20)
                            ->orderBy('quantity', 'asc')
                            ->take(5)->get();
    $lowStockCount     = Medicine::where('store_id', $storeId)->where('quantity', '<', 20)->count();

    $expiringMedicines = Medicine::where('store_id', $storeId)
                            ->whereDate('expiration_date', '<=', now()->addDays(30))
                            ->whereDate('expiration_date', '>',  now())
                            ->orderBy('expiration_date', 'asc')
                            ->take(5)->get();
    $expiringCount     = $expiringMedicines->count();

    $pendingOrders     = Order::where('store_id', $storeId)->where('status', 'pending')->count();

    $recentOrders      = Order::with(['customer.user', 'items.medicine'])
                            ->where('store_id', $storeId)
                            ->where('status', 'pending')
                            ->orderBy('created_at', 'desc')
                            ->paginate(5);

    try {
        $todayRevenue = Order::where('store_id', $storeId)
                         ->whereIn('status', ['completed', 'approved'])
                         ->sum('total_amount');

        $salesData = Order::where('store_id', $storeId)
                    ->whereIn('status', ['completed', 'approved'])
                    ->whereBetween('created_at', [now()->subDays(6)->startOfDay(), now()->endOfDay()])
                    ->selectRaw('DATE(created_at) as date, SUM(total_amount) as total')
                    ->groupBy('date')->orderBy('date')->get();
    } catch (\Throwable $e) {
        Log::error('Sales data error: '.$e->getMessage());
        $todayRevenue = 0;
        $salesData    = collect([]);
    }
// --- Figure out which drugstore is active ---
$userId = Auth::id();
$drugstore = null;

// Try Laravel Auth first
if ($userId) {
    $drugstore = Drugstore::where('user_id', $userId)->first();
}

// Fallback to session (for custom login systems)
if (!$drugstore && session()->has('drugstore_id')) {
    $drugstore = Drugstore::find(session('drugstore_id'));
}

if (!$drugstore) {
    // No match at all — show a friendly message instead of aborting
    return view('drugstore.index', [
        'recentPrescriptions' => collect(),
        'debugInfo' => ['storeId' => null, 'prescTotal' => 0, 'pageCount' => 0],
        'totalMedicines' => 0,
        'lowStockMedicines' => collect(),
        'lowStockCount' => 0,
        'pendingOrders' => 0,
        'todayRevenue' => 0,
        'recentOrders' => collect(),
        'salesData' => collect(),
        'expiringMedicines' => collect(),
        'expiringCount' => 0,
    ]);
}

// --- Fetch prescriptions linked to that drugstore ---
$recentPrescriptions = PrescriptionSubmission::where('drugstore_id', $drugstore->id)
    ->with(['customer.user', 'drugstore'])
    ->latest()
    ->paginate(5);

// Debug info for blade
$debugInfo = [
    'storeId'    => $drugstore->id,
    'prescTotal' => $recentPrescriptions->total(),
    'pageCount'  => $recentPrescriptions->count(),
];

}

    public function createMedicine()
    {
        $drugstore = \App\Models\Drugstore::where('user_id', Auth::id())->first();
        $store_id = $drugstore->id ?? null;

        // Get counts for header notifications
        $lowStockCount = Medicine::where('store_id', $store_id)
            ->where('quantity', '<', 20)
            ->count();
        
        $lowStockMedicines = Medicine::where('store_id', $store_id)
            ->where('quantity', '<', 20)
            ->orderBy('quantity', 'asc')
            ->take(5)
            ->get();

        // Get medicines expiring in 30 days
        $expiringMedicines = Medicine::where('store_id', $store_id)
            ->whereDate('expiration_date', '<=', now()->addDays(30))
            ->whereDate('expiration_date', '>', now())
            ->orderBy('expiration_date', 'asc')
            ->take(5)
            ->get();

        $expiringCount = Medicine::where('store_id', $store_id)
            ->whereDate('expiration_date', '<=', now()->addDays(30))
            ->whereDate('expiration_date', '>', now())
            ->count();

        $pendingOrders = \App\Models\Order::where('store_id', $store_id)
            ->where('status', 'pending')
            ->count();

        $recentOrders = \App\Models\Order::where('store_id', $store_id)
            ->where('status', 'pending')
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();

        return view('drugstore.add_medicine', compact(
            'lowStockCount',
            'lowStockMedicines',
            'pendingOrders',
            'recentOrders',
            'expiringMedicines',
            'expiringCount'
        ));
    }

    public function storeMedicine(Request $request)
    {
        $validatedData = $request->validate([
            'medicine_name' => 'required|string|max:255',
            'generic_name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'medicine_price' => 'required|numeric|min:0',
            'quantity' => 'required|integer|min:0',
            'manufactured_date' => 'required|date',
            'expiration_date' => 'required|date|after:manufactured_date',
            'medicine_img' => 'nullable|image|max:2048',
        ]);

        // Get the drugstore id for the logged-in user
        $drugstore = \App\Models\Drugstore::where('user_id', Auth::id())->first();
        $store_id = $drugstore->id ?? null;

        if (!$store_id) {
            return redirect()->back()->withErrors(['error' => 'Drugstore not found for this account.']);
        }

        // Handle image upload if present
        if ($request->hasFile('medicine_img')) {
            $imagePath = $request->file('medicine_img')->store('medicines', 'public');
            $validatedData['medicine_img'] = $imagePath;
        }

        $validatedData['store_id'] = $store_id;

        Medicine::create($validatedData);

        return redirect()->route('drugstore.create')->with('success', 'Medicine added successfully.');
    }

    public function viewMedicine()
    {
        // Only show medicines for the logged-in drugstore
        $drugstore = \App\Models\Drugstore::where('user_id', Auth::id())->first();
        $store_id = $drugstore->id ?? null;
        
        // Get medicines
        $medicines = Medicine::where('store_id', $store_id)->get();

        // Get counts for header notifications
        $lowStockCount = Medicine::where('store_id', $store_id)
            ->where('quantity', '<', 20)
            ->count();
        
        $lowStockMedicines = Medicine::where('store_id', $store_id)
            ->where('quantity', '<', 20)
            ->orderBy('quantity', 'asc')
            ->take(5)
            ->get();

        // Get medicines expiring in 30 days
        $expiringMedicines = Medicine::where('store_id', $store_id)
            ->whereDate('expiration_date', '<=', now()->addDays(30))
            ->whereDate('expiration_date', '>', now())
            ->orderBy('expiration_date', 'asc')
            ->take(5)
            ->get();

        $expiringCount = Medicine::where('store_id', $store_id)
            ->whereDate('expiration_date', '<=', now()->addDays(30))
            ->whereDate('expiration_date', '>', now())
            ->count();

        $pendingOrders = \App\Models\Order::where('store_id', $store_id)
            ->where('status', 'pending')
            ->count();

        $recentOrders = \App\Models\Order::where('store_id', $store_id)
            ->where('status', 'pending')
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();

        return view('drugstore.view_medicine', compact(
            'medicines',
            'lowStockCount',
            'lowStockMedicines',
            'pendingOrders',
            'recentOrders',
            'expiringMedicines',
            'expiringCount'
        ));
    }

    public function editMedicine($id)
    {
        $drugstore = \App\Models\Drugstore::where('user_id', Auth::id())->first();
        $store_id = $drugstore->id ?? null;
        
        $medicine = Medicine::findOrFail($id);

        // Get counts for header notifications
        $lowStockCount = Medicine::where('store_id', $store_id)
            ->where('quantity', '<', 20)
            ->count();
        
        $lowStockMedicines = Medicine::where('store_id', $store_id)
            ->where('quantity', '<', 20)
            ->orderBy('quantity', 'asc')
            ->take(5)
            ->get();

        // Get medicines expiring in 30 days
        $expiringMedicines = Medicine::where('store_id', $store_id)
            ->whereDate('expiration_date', '<=', now()->addDays(30))
            ->whereDate('expiration_date', '>', now())
            ->orderBy('expiration_date', 'asc')
            ->take(5)
            ->get();

        $expiringCount = Medicine::where('store_id', $store_id)
            ->whereDate('expiration_date', '<=', now()->addDays(30))
            ->whereDate('expiration_date', '>', now())
            ->count();

        $pendingOrders = \App\Models\Order::where('store_id', $store_id)
            ->where('status', 'pending')
            ->count();

        $recentOrders = \App\Models\Order::where('store_id', $store_id)
            ->where('status', 'pending')
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();

        return view('drugstore.edit_medicine', compact(
            'medicine',
            'lowStockCount',
            'lowStockMedicines',
            'pendingOrders',
            'recentOrders',
            'expiringMedicines',
            'expiringCount'
        ));
    }

    public function updateMedicine(Request $request, $id)
    {
        $validatedData = $request->validate([
            'medicine_name' => 'required|string|max:255',
            'generic_name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'medicine_price' => 'required|numeric|min:0',
            'quantity' => 'required|integer|min:0',
            'manufactured_date' => 'required|date',
            'expiration_date' => 'required|date|after:manufactured_date',
            'medicine_img' => 'nullable|image|max:2048',
        ]);

        $medicine = Medicine::findOrFail($id);

        if ($request->hasFile('medicine_img')) {
            $imagePath = $request->file('medicine_img')->store('medicines', 'public');
            $validatedData['medicine_img'] = $imagePath;
        }

        $medicine->update($validatedData);

        return redirect()->route('drugstore.view')->with('success', 'Medicine updated successfully.');
    }

    public function getTotalSales()
    {
        try {
            $drugstore = \App\Models\Drugstore::where('user_id', Auth::id())->first();
            $store_id = $drugstore->id ?? null;

            $total = \App\Models\Order::where('store_id', $store_id)
                ->whereIn('status', ['completed', 'approved'])
                ->sum('total_amount');

            return response()->json([
                'success' => true,
                'total' => $total
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error fetching total sales: ' . $e->getMessage()
            ], 500);
        }
    }

    public function getSalesData()
    {
        try {
            $drugstore = \App\Models\Drugstore::where('user_id', Auth::id())->first();
            $store_id = $drugstore->id ?? null;

            $salesData = \App\Models\Order::where('store_id', $store_id)
                ->whereIn('status', ['completed', 'approved'])
                ->whereBetween('created_at', [now()->subDays(6)->startOfDay(), now()->endOfDay()])
                ->selectRaw('DATE(created_at) as date, SUM(total_amount) as total')
                ->groupBy('date')
                ->orderBy('date')
                ->get();

            return response()->json([
                'success' => true,
                'data' => $salesData
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error fetching sales data: ' . $e->getMessage()
            ], 500);
        }
    }

    public function deleteMedicine($id)
    {
        try {
            // Find the medicine
            $medicine = Medicine::findOrFail($id);
            
            // Delete the medicine image if it exists
            if ($medicine->medicine_img) {
                Storage::disk('public')->delete($medicine->medicine_img);
            }
            
            // Delete the medicine
            $medicine->delete();
            
            return response()->json([
                'success' => true,
                'message' => 'Medicine deleted successfully'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error deleting medicine: ' . $e->getMessage()
            ], 500);
        }
    }

    public function adminViewDrugstores()
    {
        $drugstores = \App\Models\Drugstore::with(['medicines' => function($query) {
                $query->select('id', 'store_id', 'medicine_name', 'generic_name', 'medicine_price', 'quantity');
            }])
            ->orderBy('storename')
            ->paginate(10);

        return view('admin.view_drugstore', compact('drugstores'));
    }

    public function adminEditDrugstore($id)
    {
        $drugstore = \App\Models\Drugstore::findOrFail($id);
        return view('admin.edit_drugstore', compact('drugstore'));
    }

    public function adminViewSingleDrugstore($id)
    {
        $drugstore = \App\Models\Drugstore::with('medicines')->findOrFail($id);
        return view('admin.single_drugstore', compact('drugstore'));
    }

    public function adminUpdateDrugstore(Request $request, $id)
    {
        $drugstore = \App\Models\Drugstore::findOrFail($id);
        
        $validatedData = $request->validate([
            'storename' => 'required|string|max:255',
            'storeaddress' => 'required|string',
            'licenseno' => 'required|string|max:255',
            'operatingdays' => 'required|string',
            'latitude' => 'nullable|numeric',
            'longitude' => 'nullable|numeric',
            'is_active' => 'boolean'
        ]);

        $drugstore->update($validatedData);
        return redirect()->route('admin.drugstore.view')
            ->with('success', 'Drugstore updated successfully');
    }

    public function adminDeleteDrugstore($id)
    {
        try {
            $drugstore = \App\Models\Drugstore::findOrFail($id);
            $drugstore->delete();
            
            return response()->json([
                'success' => true,
                'message' => 'Drugstore deleted successfully'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error deleting drugstore: ' . $e->getMessage()
            ], 500);
        }
    }

    public function getNearbyDrugstores()
    {
        try {
            $drugstores = \App\Models\Drugstore::select('id', 'storename', 'storeaddress', 'latitude', 'longitude')
                ->whereNotNull('latitude')
                ->whereNotNull('longitude')
                ->get();

            return response()->json([
                'success' => true,
                'data' => $drugstores
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error fetching drugstores: ' . $e->getMessage()
            ], 500);
        }
    }
}
