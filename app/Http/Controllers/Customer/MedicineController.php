<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Medicine;
use Illuminate\Http\Request;

class MedicineController extends Controller
{
    public function search(Request $request)
    {
        $query = $request->get('query');
        
        // Debug: Log the search query
        \Log::info('Medicine search query: ' . $query);
        
        // Get initial query to check what medicines exist
        $allMedicines = Medicine::count();
        \Log::info('Total medicines in database: ' . $allMedicines);
        
        // Build the query with proper grouping
        $query_builder = Medicine::where('quantity', '>', 0)
            ->where(function($q) use ($query) {
                $q->where('medicine_name', 'like', "%{$query}%")
                  ->orWhere('generic_name', 'like', "%{$query}%")
                  ->orWhere('description', 'like', "%{$query}%");
            })
        ->with('store'); // Eager load store relationship

        // Debug: Log the SQL query
        \Log::info('SQL Query: ' . $query_builder->toSql());
        \Log::info('SQL Bindings: ' . json_encode($query_builder->getBindings()));

        try {
            // Execute the query
            $medicines = $query_builder->take(5)->get();
            
            // Debug: Log the results count
            \Log::info('Found medicines count: ' . $medicines->count());
            if ($medicines->isEmpty()) {
                \Log::info('No medicines found for query: ' . $query);
                return response()->json([]);
            }

            $mapped_medicines = $medicines->map(function($medicine) {
                try {
                    if (!$medicine->store) {
                        \Log::warning('Medicine ID ' . $medicine->id . ' has no associated store');
                        return null;
                    }
                    
                    return [
                        'id' => $medicine->id,
                        'medicine_name' => $medicine->medicine_name,
                        'generic_name' => $medicine->generic_name,
                        'medicine_price' => (float)$medicine->medicine_price,
                        'quantity' => $medicine->quantity,
                        'image' => $medicine->medicine_img ? asset('storage/' . $medicine->medicine_img) : asset('admin/assets/images/icon/medicine.png'),
                        'drugstore' => [
                            'id' => $medicine->store->id,
                            'name' => $medicine->store->storename
                        ]
                    ];
                } catch (\Exception $e) {
                    \Log::error('Error mapping medicine: ' . $e->getMessage());
                    return null;
                }
            })->filter()->values();

            return response()->json($mapped_medicines);
        } catch (\Exception $e) {
            \Log::error('Search error: ' . $e->getMessage());
            return response()->json(['error' => 'Error searching medicines'], 500);
        }
    }
}
