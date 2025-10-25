<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use App\Models\PrescriptionSubmission;
use App\Models\Customer;

class PrescriptionSubmissionController extends Controller
{
    /**
     * Customer submits a prescription to a drugstore.
     */
    public function store(Request $request)
    {
        try {
            Log::info('Prescription submission attempt started', [
                'user_id' => Auth::id(),
                'request' => $request->all(),
            ]);

            // Validate input
            $validated = $request->validate([
                'drugstore_id'    => 'required|exists:drugstores,id',
                'file'            => 'required|file|mimes:jpg,jpeg,png,pdf|max:2048',
                'description'     => 'nullable|string|max:1000',
            ]);

            // Check if user has a linked customer
            $customer = Customer::where('user_id', Auth::id())->first();
            if (!$customer) {
                Log::error('No linked customer found for user', ['user_id' => Auth::id()]);
                return redirect()->back()->with('error', 'No linked customer record found for this user.');
            }

            // Try to store the uploaded file
            if (!$request->hasFile('file')) {
                Log::error('No file detected in the request', ['user_id' => Auth::id()]);
                return redirect()->back()->with('error', 'No file was uploaded.');
            }

            $path = $request->file('file')->store('prescriptions', 'public');
            Log::info('File uploaded successfully', ['path' => $path]);

            // Attempt to create the prescription submission
            $submission = PrescriptionSubmission::create([
                'customer_id'     => $customer->id,
                'drugstore_id'    => $validated['drugstore_id'],
                'file_path'       => $path,
                'description'     => $validated['description'] ?? null,
                'status'          => 'pending',
                'sent_at'         => now(),
            ]);

            Log::info('Prescription submission saved successfully', [
                'submission_id' => $submission->id,
                'customer_id'   => $customer->id,
            ]);

            return redirect()->back()->with('success', 'Prescription submitted successfully!');

        } catch (\Throwable $e) {
            Log::error('Prescription submission failed', [
                'user_id' => Auth::id(),
                'error_message' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'trace' => $e->getTraceAsString(),
            ]);

            return redirect()->back()->with('error', 'Something went wrong while saving the prescription. Check the logs for details.');
        }
    }

    /**
     * Drugstore approves a prescription submission.
     */
    public function approve($id)
    {
        try {
            $pres = PrescriptionSubmission::findOrFail($id);
            $pres->update(['status' => 'approved']);
            Log::info('Prescription approved', ['id' => $id, 'user_id' => Auth::id()]);
            return response()->json(['success' => true]);
        } catch (\Throwable $e) {
            Log::error('Error approving prescription', ['id' => $id, 'error' => $e->getMessage()]);
            return response()->json(['success' => false, 'message' => 'Error approving prescription']);
        }
    }

    /**
     * Drugstore rejects a prescription submission.
     */
    public function reject($id)
    {
        try {
            $pres = PrescriptionSubmission::findOrFail($id);
            $pres->update(['status' => 'rejected']);
            Log::info('Prescription rejected', ['id' => $id, 'user_id' => Auth::id()]);
            return response()->json(['success' => true]);
        } catch (\Throwable $e) {
            Log::error('Error rejecting prescription', ['id' => $id, 'error' => $e->getMessage()]);
            return response()->json(['success' => false, 'message' => 'Error rejecting prescription']);
        }
    }

    /**
     * Fetch approved/rejected prescriptions for notifications.
     */
    public function checkCustomerNotifications()
    {
        try {
            $customer = Customer::where('user_id', Auth::id())->first();
            if (!$customer) {
                Log::warning('Notification check: no linked customer', ['user_id' => Auth::id()]);
                return response()->json(['notifications' => []]);
            }

            $notifications = PrescriptionSubmission::where('customer_id', $customer->id)
                ->whereIn('status', ['approved', 'rejected'])
                ->latest('updated_at')
                ->take(10)
                ->get(['id', 'status', 'updated_at']);

            Log::info('Notification check success', [
                'user_id' => Auth::id(),
                'count'   => $notifications->count(),
            ]);

            return response()->json(['notifications' => $notifications]);
        } catch (\Throwable $e) {
            Log::error('Error fetching notifications', [
                'user_id' => Auth::id(),
                'error' => $e->getMessage(),
            ]);
            return response()->json(['notifications' => []]);
        }
    }
}
