<?php

// List available models for the API key
// Run with: php list-models.php

require __DIR__ . '/vendor/autoload.php';

// Load .env
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

$apiKey = $_ENV['GEMINI_API_KEY'] ?? '';

echo "=== LIST AVAILABLE GEMINI MODELS ===\n\n";
echo "API Key: " . substr($apiKey, 0, 10) . "..." . substr($apiKey, -4) . "\n\n";

$url = "https://generativelanguage.googleapis.com/v1beta/models?key={$apiKey}";

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_TIMEOUT, 30);

$response = curl_exec($ch);
$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
curl_close($ch);

echo "HTTP Code: $httpCode\n\n";

if ($httpCode === 200) {
    $data = json_decode($response, true);
    
    if (isset($data['models'])) {
        echo "Available models:\n";
        foreach ($data['models'] as $model) {
            $name = $model['name'] ?? 'unknown';
            $displayName = $model['displayName'] ?? '';
            // Only show generateContent capable models
            if (isset($model['supportedGenerationMethods']) && in_array('generateContent', $model['supportedGenerationMethods'])) {
                echo "  - $name ($displayName) ✓ generateContent\n";
            }
        }
    } else {
        echo "No models found in response\n";
        echo "Response: " . $response . "\n";
    }
} else {
    echo "FAILED to list models\n";
    echo "Response: " . $response . "\n";
}
