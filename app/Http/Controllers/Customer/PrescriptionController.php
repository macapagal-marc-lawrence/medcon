<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Prescription;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PrescriptionController extends Controller
{
    public function index()
    {
        $prescriptions = auth()->user()->customer->prescriptions()
            ->latest()
            ->paginate(10);
            
        return view('customer.prescriptions.index', compact('prescriptions'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'notes' => 'required|string|max:1000',
        ]);

        try {
            $prescription = new Prescription([
                'customer_id' => auth()->user()->customer->id,
                'notes' => $request->notes,
                'status' => 'pending'
            ]);

            $prescription->save();

            return response()->json([
                'success' => true,
                'message' => 'Prescription uploaded successfully',
                'prescription' => $prescription
            ]);
        } catch (\Exception $e) {
            \Log::error('Error uploading prescription: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Error uploading prescription. Please try again.'
            ], 500);
        }
    }

    public function show(Prescription $prescription)
    {
        if ($prescription->customer_id !== auth()->user()->customer->id) {
            abort(403);
        }
        
        return view('customer.prescriptions.show', compact('prescription'));
    }

    public function pending()
    {
        $prescriptions = auth()->user()->customer->prescriptions()
            ->where('status', 'pending')
            ->latest()
            ->paginate(10);
            
        return view('customer.prescriptions.index', compact('prescriptions'));
    }

    public function approved()
    {
        $prescriptions = auth()->user()->customer->prescriptions()
            ->where('status', 'approved')
            ->latest()
            ->paginate(10);
            
        return view('customer.prescriptions.index', compact('prescriptions'));
    }

    public function rejected()
    {
        $prescriptions = auth()->user()->customer->prescriptions()
            ->where('status', 'rejected')
            ->latest()
            ->paginate(10);
            
        return view('customer.prescriptions.index', compact('prescriptions'));
    }
}
