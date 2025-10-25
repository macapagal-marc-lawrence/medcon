<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Prescription;
use App\Models\PrescriptionSubmission;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class PrescriptionController extends Controller
{
    /**
     * Display a listing of the customer's prescriptions.
     */
    public function index()
    {
        $prescriptions = auth()->user()->customer->prescriptions()
            ->latest()
            ->paginate(10);

        return view('customer.prescriptions.index', compact('prescriptions'));
    }

    /**
     * Store a new prescription (text notes only).
     */
    public function store(Request $request)
    {
        $request->validate([
            'notes' => 'required|string|max:1000',
        ]);

        try {
            $prescription = new Prescription([
                'customer_id' => auth()->user()->customer->id,
                'notes' => $request->notes,
                'status' => 'pending',
            ]);

            $prescription->save();

            return response()->json([
                'success' => true,
                'message' => 'Prescription uploaded successfully',
                'prescription' => $prescription,
            ]);
        } catch (\Exception $e) {
            \Log::error('Error uploading prescription: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Error uploading prescription. Please try again.',
            ], 500);
        }
    }

    /**
     * Display a specific prescription.
     */
    public function show(Prescription $prescription)
    {
        if ($prescription->customer_id !== auth()->user()->customer->id) {
            abort(403);
        }

        return view('customer.prescriptions.show', compact('prescription'));
    }

    /**
     * Show pending prescriptions.
     */
    public function pending()
    {
        $prescriptions = auth()->user()->customer->prescriptions()
            ->where('status', 'pending')
            ->latest()
            ->paginate(10);

        return view('customer.prescriptions.index', compact('prescriptions'));
    }

    /**
     * Show approved prescriptions.
     */
    public function approved()
    {
        $prescriptions = auth()->user()->customer->prescriptions()
            ->where('status', 'approved')
            ->latest()
            ->paginate(10);

        return view('customer.prescriptions.index', compact('prescriptions'));
    }

    /**
     * Show rejected prescriptions.
     */
    public function rejected()
    {
        $prescriptions = auth()->user()->customer->prescriptions()
            ->where('status', 'rejected')
            ->latest()
            ->paginate(10);

        return view('customer.prescriptions.index', compact('prescriptions'));
    }

    /**
     * Submit a prescription to a selected drugstore.
     */
    public function submitToDrugstore(Request $request)
    {
        $request->validate([
            'prescription_id' => 'required|exists:prescriptions,id',
            'drugstore_id' => 'required|exists:drugstores,id',
            'file' => 'required|file|mimes:jpg,jpeg,png,pdf|max:2048',
            'description' => 'nullable|string|max:500',
        ]);

        try {
            // 🗂️ Store file in 'storage/app/public/prescriptions'
            $filePath = $request->file('file')->store('prescriptions', 'public');

            // 💾 Create prescription submission record
            PrescriptionSubmission::create([
                'prescription_id' => $request->prescription_id,
                'customer_id' => Auth::user()->customer->id,
                'drugstore_id' => $request->drugstore_id,
                'file_path' => $filePath,
                'description' => $request->description,
                'status' => 'pending',
                'customer_notified' => false,
                'sent_at' => now(),
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Prescription successfully submitted to the selected drugstore.',
            ]);
        } catch (\Exception $e) {
            \Log::error('Prescription submission failed: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Failed to submit prescription. Please try again.',
            ], 500);
        }
    }
}
