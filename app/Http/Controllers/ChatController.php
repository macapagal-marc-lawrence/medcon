<?php

namespace App\Http\Controllers;

use App\Services\OpenRouterService;
use Illuminate\Http\Request;

class ChatController extends Controller
{
    private $openRouter;

    public function __construct(OpenRouterService $openRouter)
    {
        $this->openRouter = $openRouter;
    }

    public function chat(Request $request)
    {
        $message = $request->input('message');
        $response = $this->openRouter->chat($message);

        return response()->json([
            'success' => !is_null($response),
            'message' => $response ?? 'Sorry, I encountered an error. Please try again.'
        ]);
    }

    public function analyzePrescription(Request $request)
    {
        try {
            $prescriptionText = $request->input('prescription');
            
            if (empty($prescriptionText)) {
                return response()->json([
                    'success' => false,
                    'analysis' => 'Please enter prescription details.'
                ]);
            }

            $analysis = $this->openRouter->analyzePrescription($prescriptionText);

            // Check if the response is an error message
            if (strpos($analysis, 'Error:') === 0 || 
                strpos($analysis, 'API Key authentication failed') === 0 ||
                strpos($analysis, 'Rate limit exceeded') === 0) {
                return response()->json([
                    'success' => false,
                    'analysis' => $analysis
                ]);
            }

            return response()->json([
                'success' => true,
                'analysis' => $analysis ?? 'Sorry, I could not analyze the prescription. Please try again.'
            ]);
        } catch (\Exception $e) {
            \Log::error('Prescription Analysis Controller Error: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'analysis' => 'An unexpected error occurred. Please try again.'
            ]);
        }
    }
}
