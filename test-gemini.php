<?php

// Test Gemini API directly
// Run with: php test-gemini.php

require __DIR__ . '/vendor/autoload.php';

// Load .env
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

$apiKey = $_ENV['GEMINI_API_KEY'] ?? '';

echo "=== GEMINI API TEST ===\n\n";
echo "API Key: " . substr($apiKey, 0, 10) . "..." . substr($apiKey, -4) . "\n";
echo "Key Length: " . strlen($apiKey) . "\n\n";

if (empty($apiKey)) {
    echo "ERROR: No API key found!\n";
    exit(1);
}

// Test multiple models
$models = [
    'gemini-1.5-flash',
    'gemini-1.5-pro',
    'gemini-2.0-flash',
    'gemini-2.0-flash-exp',
    'gemini-pro',
];

foreach ($models as $model) {
    echo "Testing model: $model\n";
    
    $url = "https://generativelanguage.googleapis.com/v1beta/models/{$model}:generateContent?key={$apiKey}";
    
    $data = [
        'contents' => [
            [
                'parts' => [
                    ['text' => 'Say hello in Bahasa Indonesia (just 2 words)']
                ]
            ]
        ],
        'generationConfig' => [
            'maxOutputTokens' => 50,
        ]
    ];
    
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
    curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_TIMEOUT, 30);
    
    $response = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);
    
    echo "  HTTP Code: $httpCode\n";
    
    if ($httpCode === 200) {
        $result = json_decode($response, true);
        $text = $result['candidates'][0]['content']['parts'][0]['text'] ?? 'No response';
        echo "  SUCCESS! Response: $text\n";
        echo "\n=== WORKING MODEL FOUND: $model ===\n";
        break;
    } else {
        $error = json_decode($response, true);
        $message = $error['error']['message'] ?? 'Unknown error';
        echo "  FAILED: $message\n";
    }
    
    echo "\n";
    sleep(2); // Wait between requests
}

echo "\nTest complete.\n";
