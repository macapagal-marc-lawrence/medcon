<?php

namespace App\Services;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;

class OpenRouterService
{
    private $client;
    private $apiKey;
    private $baseUrl = 'https://openrouter.ai/api/v1/chat/completions';

    public function __construct()
    {
        $this->apiKey = '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';
        $this->client = new Client([
            'base_uri' => $this->baseUrl,
            'headers' => [
                'Authorization' => "Bearer {$this->apiKey}",
                'HTTP-Referer' => 'http://localhost',  // Local development
                'X-Title' => 'MediConnect',
                'Content-Type' => 'application/json'
            ]
        ]);
    }

    public function chat($message, $context = [])
    {
        try {
            $response = $this->client->post('/chat/completions', [
                'json' => [
                    'model' => 'openai/gpt-oss-20b:free', // Using the free OSS model
                    'messages' => array_merge([
                        [
                            'role' => 'system',
                            'content' => 'You are a helpful medical assistant for MediConnect, helping users with prescriptions and medical queries. Always be professional and accurate.'
                        ]
                    ], $context, [
                        [
                            'role' => 'user',
                            'content' => $message
                        ]
                    ])
                ]
            ]);

            $result = json_decode($response->getBody()->getContents(), true);
            return $result['choices'][0]['message']['content'] ?? null;

        } catch (GuzzleException $e) {
            // Log the error
            \Log::error('OpenRouter API Error: ' . $e->getMessage());
            return null;
        }
    }

    public function analyzePrescription($prescriptionText)
    {
        try {
            // Get all registered drugstores with their medicines
            $drugstores = \App\Models\Drugstore::with(['medicines' => function($query) {
                $query->select('id', 'store_id', 'medicine_name', 'generic_name', 'medicine_price', 'quantity')
                    ->where('quantity', '>', 0)
                    ->orderBy('medicine_price', 'asc');
            }])->get();

            \Log::info('Sending prescription analysis request:', [
                'text_length' => strlen($prescriptionText),
                'api_key_present' => !empty($this->apiKey),
                'available_drugstores' => $drugstores->count()
            ]);

            $systemPrompt = <<<EOT
You are a helpful medical assistant in the Philippines providing clear, practical recommendations for taking medications. You have access to real-time medicine availability data from registered drugstores in our system. When mentioning medicines and drugstores from our database, display them in blue color using HTML font tags (e.g., <font color='blue'>Medicine Name</font>). Based on this prescription and our available data, provide recommendations as follows:

1. TAKING YOUR MEDICINES

For each medicine in the prescription, I will provide:
[Medicine Name] (Generic Name)
- Best times to take: (Consider Filipino meal times - almusal, tanghalian, hapunan)
- Take with: (Suggest local options)
- Available at: (I will list actual drugstores where it's available)
- Current prices: (I will list actual prices from our registered drugstores)
- Storage: (Consider Philippine climate)

Here is our current drugstore and medicine data:
{$this->formatDrugstoreData($drugstores)}

[Please use the above real drugstore data when suggesting where to buy medicines]

2. DAILY HABITS
- Recommended Filipino foods: (lugaw, sopas, tinola, etc.)
- Foods to avoid
- Activities for our climate
- Rest tips for typical Filipino schedule
- Keeping medicines safe in humid weather

3. IMPORTANT REMINDERS
- When to contact your doctor
- Side effects to watch for
- Emergency numbers to save
- Operating hours of recommended drugstores
- Delivery options if available

4. HOME CARE TIPS
- Safe traditional remedies (if any)
- Managing symptoms at home
- Family support suggestions
- Tips for our weather
- When to use cooling/electric fan

IMPORTANT: 
1. Only recommend medicines that are currently available in our registered drugstores
2. Always provide actual prices from our database
3. Include operating days of the recommended drugstores
4. Keep recommendations practical and easy to follow
5. Use simple language and focus on what helps the patient feel better and recover safely
EOT;

            $requestBody = [
                'json' => [
                    'model' => 'gpt-3.5-turbo',
                    'messages' => [
                        [
                            'role' => 'system',
                            'content' => $systemPrompt
                        ],
                        [
                            'role' => 'user',
                            'content' => "Please provide a professional analysis of this prescription: $prescriptionText"
                        ]
                    ],
                    'temperature' => 0.7,
                    'max_tokens' => 800
                ]
            ];

            \Log::info('Request body:', $requestBody);

            $response = $this->client->post('', $requestBody);
            $responseBody = $response->getBody()->getContents();
            
            \Log::info('API Response:', ['response' => $responseBody]);

            $result = json_decode($responseBody, true);
            
            if (!isset($result['choices'][0]['message']['content'])) {
                \Log::error('Unexpected API response structure:', ['response' => $result]);
                return 'Error: Unexpected API response structure';
            }

            return $result['choices'][0]['message']['content'];

        } catch (GuzzleException $e) {
            $errorMessage = $e->getMessage();
            
            // Log detailed error information
            \Log::error('OpenRouter Prescription Analysis Error Details:', [
                'error_message' => $errorMessage,
                'request_url' => $this->baseUrl . '/chat/completions',
                'api_key_length' => strlen($this->apiKey),
                'prescription_length' => strlen($prescriptionText),
                'response_body' => $e->hasResponse() ? $e->getResponse()->getBody()->getContents() : 'No response body'
            ]);
            
            if ($e->hasResponse()) {
                $response = json_decode($e->getResponse()->getBody()->getContents(), true);
                $errorDetail = $response['error']['message'] ?? $errorMessage;
                return "API Error: " . $errorDetail;
            }
            
            // Check if it's an authentication error
            if (strpos($errorMessage, '401') !== false) {
                return 'API Key authentication failed. Please check your OpenRouter API key.';
            }
            
            // Check if it's a rate limit error
            if (strpos($errorMessage, '429') !== false) {
                return 'Rate limit exceeded. Please try again in a few moments.';
            }

            return 'Error: ' . $errorMessage;
        }
    }

    private function formatDrugstoreData($drugstores)
    {
        $formattedData = "AVAILABLE MEDICINES IN REGISTERED DRUGSTORES:\n\n";
        
        foreach ($drugstores as $drugstore) {
            $formattedData .= "Drugstore: <font color='blue'>{$drugstore->storename}</font>\n";
            $formattedData .= "Address: {$drugstore->storeaddress}\n";
            $formattedData .= "Operating Days: {$drugstore->operatingdays}\n";
            $formattedData .= "Available Medicines:\n";
            
            foreach ($drugstore->medicines as $medicine) {
                $formattedData .= "- <font color='blue'>{$medicine->medicine_name}</font> (Generic: {$medicine->generic_name})\n";
                $formattedData .= "  Price: PHP {$medicine->medicine_price}\n";
                $formattedData .= "  Stock: {$medicine->quantity} units available\n";
            }
            
            $formattedData .= "\n";
        }
        
        return $formattedData;
    }
}
